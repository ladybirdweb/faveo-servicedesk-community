<?php

namespace App\Plugins\ServiceDesk\Controllers\FormBuilder;

use App\Plugins\ServiceDesk\Controllers\BaseServiceDeskController;
use App\Plugins\ServiceDesk\Model\FormBuilder\Form;
use App\Plugins\ServiceDesk\Model\FormBuilder\FormField;
use App\Plugins\ServiceDesk\Model\FormBuilder\FormValue;
use Exception;
use Illuminate\Http\Request;

class FormBuilderController extends BaseServiceDeskController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('service::form-builder.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:sd_forms',
            'form'  => 'required',
        ]);

        try {
            $forms = new Form();
            $form = $request->input('form');
            $title = $request->input('title');
            $xmlNode = simplexml_load_string($form);
            $forms->title = $title;
            $forms->save();
            $arrayData = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::xmlToArray($xmlNode);
            $save = $this->saveField($forms->id, $arrayData);
            $result = ['fails' => "We can't process your request"];
            if ($save) {
                $result = ['success' => "Form $forms->title created successfully"];
            }

            return response()->json(compact('result'));
        } catch (Exception $ex) {
            dd($ex);
            $result = ['fails' => $ex->getMessage()];

            return response()->json(compact('result'));
        }
    }

    public function saveField($formid, $data)
    {
        //dd($data);
        $fields = new FormField();
        $items = $fields->where('form_id', $formid)->get();
        if ($items->count() > 0) {
            foreach ($items as $item) {
                $item->delete();
            }
        }
        foreach ($data['form-template']['fields']['field'] as $index => $item) {
            $field = $fields->create([
                'name'        => $this->checkField('name', $item),
                'label'       => $this->checkField('label', $item),
                'form_id'     => $formid,
                'type'        => $this->checkField('type', $item),
                'sub_type'    => $this->checkField('subtype', $item),
                'class'       => $this->checkField('class', $item),
                'is_required' => $this->checkField('required', $item),
                'placeholder' => $this->checkField('placeholder', $item),
                'description' => $this->checkField('description', $item),
                'multiple'    => $this->checkField('multiple', $item),
                'role'        => $this->checkField('role', $item),
            ]);
            if (is_string($item)) {
                if ($index == 'option') {
                    $this->saveFieldValue($field->id, $item['option']);
                }
            } elseif (array_key_exists('option', $item)) {
                $this->saveFieldValue($field->id, $item['option']);
            }
        }
        if ($field) {
            return 'success';
        }
    }

    public function saveFieldValue($fieldid, $options = [])
    {
        $values = new FormValue();
        foreach ($options as $option) {
            $values->create([
                'field_id' => $fieldid,
                'option'   => $option['option-name'],
                'value'    => $option['value'],
            ]);
        }
    }

    public function checkField($name, $array)
    {
        $res = '';
        if (is_string($array)) {
            $res = $array;
        } elseif (array_key_exists($name, $array)) {
            $res = $array[$name];
        }

        return $res;
    }

    public function renderHtmlByFormId($id, $view = true, $assetid = '')
    {
        $html = '';
        $forms = new \App\Plugins\ServiceDesk\Model\Assets\AssetFormRelation();
        $form = $forms->where('asset_type_id', $id)->first();
        if ($form) {
            $title = $form->title;
            $html = "<h1>$title</h1>".$this->getFields($form->id, $assetid);
        }
        if ($view == true) {
            return view('service::form-builder.show', compact('html'));
        } else {
            return $html;
        }
    }

    public function getFields($formid, $assetid = '', $json = false)
    {
        $item = '';
        $fields = new FormField();
        $field = $fields->where('form_id', $formid)->get();

        if ($field->count() > 0) {
            foreach ($field as $key => $html) {
                $name = $this->checkField('name', $html->toArray());

                $label = $this->checkField('label', $html->toArray());
                $type = $this->checkField('type', $html->toArray());
                $sub_type = $this->checkField('sub_type', $html->toArray());
                $class = $this->checkField('class', $html->toArray());
                $is_required = $this->checkField('is_required', $html->toArray());
                $placeholder = $this->checkField('placeholder', $html->toArray());
                $description = $this->checkField('description', $html->toArray());
                $multiple = $this->checkField('multiple', $html->toArray());
                $role = $this->checkField('role', $html->toArray());

                if ($json == true) {
                    $item['form-template']['fields'][$key] = $this->getJson($key, $html->id, $name, $label, $type, $sub_type, $class, $is_required, $placeholder, $description, $multiple, $role);
                } else {
                    //dd([$html->id, $name, $label, $type, $sub_type, $class, $is_required, $placeholder, $description, $multiple]);
                    //$item .="<form id='form'>";
                    $item .= "<div class='form-group col-md-6'>";
                    $item .= $this->fields($html->id, $name, $label, $type, $sub_type, $class, $is_required, $placeholder, $description, $multiple, $assetid);
                    $item .= '</div>';
                }
                //$item .= "</form>";
            }
        }

        //dd($item);
        return $item;
    }

    public function fields($fieldid, $name, $label, $type, $sub_type, $class, $is_required, $placeholder, $description, $multiple, $assetid = '')
    {
        $required = '';
        $html = '';
        if ($is_required == 'true') {
            $required = 'required';
        }
        switch ($type) {
            case 'button':
                return "<$sub_type class='$class' name='$name'>$label</$sub_type>";
            case 'checkbox':
                return "<label>$label</label>"
                        ."<input type='$type' class='$class' placeholder='$placeholder' name='$name' $required>";
            case 'paragraph':
                return "<$sub_type class='$class'></$sub_type>";
            case 'header':
                return "<$sub_type class='$class'></$sub_type>";
            case 'textarea':
                return "<label>$label</label><$type class='$class' placeholder='$placeholder' $required></$type>";
            case 'text':
                return "<label>$label</label>"
                        //.\Form::text($name,null,['class'=>$class,'placeholder'=>$placeholder,'required'=>$is_required]);
                        ."<input type='$type' class='$class' placeholder='$placeholder' name='$name' value=".$this->value($fieldid, $assetid)." $required>";
            case 'date':
                return "<label>$label</label>"
                        ."<input type='$type' class='$class' placeholder='$placeholder' name='$name' $required>";
            case 'file':
                return "<label>$label</label>"
                        ."<input type='$type' class='$class' placeholder='$placeholder' name='$name' $required>";
            case 'checkbox-group':
                return $this->groupValue($fieldid, $name, $label, $type, $sub_type, $class, $required, $placeholder, $description, $multiple);
            case 'radio-group':
                return $this->groupValue($fieldid, $name, $label, $type, $sub_type, $class, $required, $placeholder, $description, $multiple);
            case 'select':
                return $this->groupValue($fieldid, $name, $label, $type, $sub_type, $class, $required, $placeholder, $description, $multiple);
        }

        return $html;
    }

    public function groupValue($fieldid, $name, $label, $type, $sub_type, $class, $required, $placeholder, $description, $multiple, $json = false)
    {
        $values = new FormValue();
        $html = '';
        $value = $values->where('field_id', $fieldid)->get();
        $html = $this->getForeach($value, $name, $label, $type, $sub_type, $class, $required, $placeholder, $description, $multiple, $json);

        return $html;
    }

    public function getForeach($values, $name, $label, $type, $sub_type, $class, $required, $placeholder, $description, $multiple, $json)
    {
        $html = '';
        $array = [];
        if (count($values) > 0) {
            if ($type == 'checkbox-group') {
                $html .= "<label>$label</label></br>";
                foreach ($values as $index => $value) {
                    //if ($json == false) {
                    $html .= "<input type='checkbox' name='$name' class='$class' value='$value->value'>".$value->option.'</br>';
                    //                    } else {
//                        $array[$index] = $values->lists('option','value')->toArray();
//                    }
                }
            }
            if ($type == 'radio-group') {
                $html .= "<label>$label</label></br>";
                foreach ($values as $index => $value) {
                    //if ($json == false) {
                    $html .= "<input type='radio' name='$name' class='$class' value='$value->value'>".$value->option.'</br>';
                    //                    } else {
//                        $array[$index] = $value->lists('option','value')->toArray();
//                    }
                }
            }
            if ($type == 'select') {
                $html .= "<label>$label</label><select class='$class' name='$name' placeholder='$placeholder' $required>";
                foreach ($values as $index => $value) {
                    //if ($json == false) {
                    $html .= "<option value='$value->value'>".$value->option.'</option>';
                    //} else {
                    //$array[$index] = $value->lists('option','value')->toArray();
                    //}
                }
                $html .= '</select>';
            }
        }
        if ($json == false) {
            return $html;
        }

        return $values->lists('option', 'value')->toArray();
    }

    public function value($formid, $assetid = '')
    {
        $result = '';
        if ($assetid !== '') {
            $fields = new FormField();
            $field = $fields->find($formid);
            if ($field) {
                $name = $field->name;
                $asset_forms = new \App\Plugins\ServiceDesk\Model\Assets\AssetForm();
                $form = $asset_forms->where('asset_id', $assetid)->where('key', $name)->first();
                if ($form) {
                    $result = $form->value;
                }
            }
        }

        return $result;
    }

    public function index()
    {
        try {
            return view('service::form-builder.index');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function getForm()
    {
        $forms = new Form();
        $form = $forms->select('id', 'title')->get();

        return \Datatable::Collection($form)
                        ->showColumns('title')
                        ->addColumn('action', function ($model) {
                            $preview = $this->show($model->id, 'popup');
                            $url = url('service-desk/form-builder/'.$model->id.'/delete');
                            $title = "Delete $model->title";
                            $delete = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::deletePopUp($model->id, $url, $title);

                            return '<a href='.url('service-desk/form-builder/'.$model->id.'/edit')." class='btn btn-sm btn-primary'>Edit</a> "
                                    .$preview.$delete;
                        })
                        ->searchColumns('title')
                        ->orderColumns('title')
                        ->make();
    }

    public function edit($id)
    {
        try {
            $title = '';
            $forms = new Form();
            $form = $forms->find($id);
            if ($form) {
                $title = $form->title;
            }
            $fields = $this->convertForm($id);
            $array = $fields->toArray();
            $values = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::arrayToXml($array);
            $xml = "<form-template><fields>$values</fields></form-template>";
            $xml = str_replace('<field ></field>', '', $xml);

            return view('service::form-builder.edit', compact('xml', 'title', 'form'));
        } catch (Exception $ex) {
            dd($ex);

            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function getArray($key, $name, $label, $type, $sub_type, $class, $is_required, $placeholder, $description, $multiple, $role, $options = [])
    {
        $item['name'] = $name;
        $item['label'] = $label;
        $item['type'] = $type;
        $item['subtype'] = $sub_type;
        $item['class'] = $class;
        $item['placeholder'] = $placeholder;
        $item['description'] = $description;
        $item['multiple'] = $multiple;
        $item['role'] = $role;
        $item['options'] = $options;

        return $item;
    }

    public function getJson($key, $fieldid, $name, $label, $type, $sub_type, $class, $is_required, $placeholder, $description, $multiple, $role, $options = [])
    {
        $options = $this->groupValue($fieldid, $name, $label, $type, $sub_type, $class, $is_required, $placeholder, $description, $multiple, true);
        $array = $this->getArray($key, $name, $label, $type, $sub_type, $class, $is_required, $placeholder, $description, $multiple, $role, $options);

        return $array;
    }

    public function convertForm($formid)
    {
        $array = $this->getFields($formid, '', true);
        $collection = new \Illuminate\Support\Collection($array);

        return $collection;
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:sd_forms',
            'form'  => 'required',
        ]);

        try {
            $forms = new Form();
            $model = $forms->find($id);
            if (!$model) {
                $result = ['fails' => "We can't process your request"];

                return response()->json(compact('result'));
            }
            $form = $request->input('form');
            $title = $request->input('title');
            $xmlNode = simplexml_load_string($form);
            $model->title = $title;
            $model->save();
            $arrayData = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::xmlToArray($xmlNode);
            $save = $this->saveField($model->id, $arrayData);
            $result = ['fails' => "We can't process your request"];
            if ($save) {
                $result = ['success' => "Form $forms->title Updated successfully"];
            }

            return response()->json(compact('result'));
        } catch (Exception $ex) {
            $result = ['fails' => $ex->getMessage()];

            return response()->json(compact('result'));
        }
    }

    public function show($id, $render = 'view')
    {
        try {
            $html = '';
            $title = '';
            $forms = new Form();
            $form = $forms->find($id);
            if ($form) {
                $title = $form->title;
                $html = $this->getFields($form->id);
            }
            switch ($render) {
                case 'view':
                    $html = "<h1>$title</h1>".$html;

                    return view('service::form-builder.show', compact('html'));
                case 'popup':
                    return $this->popUp($id, $title, $html);
                default:
                    return $html;
            }
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function popUp($id, $title, $html)
    {
        return '<a href="#form" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#form'.$id.'">Preview</a>
                <div class="modal fade" id="form'.$id.'">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">'.$title.'</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                <div class="col-md-12">
                                '.$html.'
                                </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="close" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>';
    }

    public function delete($id)
    {
        try {
            $forms = new Form();
            $form = $forms->find($id);
            if ($form) {
                $form->delete();
            }

            return redirect()->back()->with('success', "$form->title deleted successfully");
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }
}
