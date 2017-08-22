<?php

namespace App\Plugins\ServiceDesk\Controllers\Assetstypes;

use App\Plugins\ServiceDesk\Controllers\BaseServiceDeskController;
use App\Plugins\ServiceDesk\Controllers\FormBuilder\FormBuilderController;
use App\Plugins\ServiceDesk\Model\Assets\AssetFormRelation;
use App\Plugins\ServiceDesk\Model\Assets\SdAssettypes;
use App\Plugins\ServiceDesk\Model\FormBuilder\Form;
use App\Plugins\ServiceDesk\Requests\CreateAssetstypesRequest;
use Exception;
use Illuminate\Http\Request;

class AssetstypesController extends BaseServiceDeskController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return type
     */
    public function index()
    {
        try {
            return view('service::assetstypes.index');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * @return type
     */
    public function getAssetstypes()
    {
        try {
            $asset = new SdAssettypes();
            $assets = $asset->select('id', 'name', 'parent_id', 'created_at', 'updated_at')->get();

            return \Datatable::Collection($assets)
                            ->showColumns('name', 'created_at', 'updated_at')
                            ->addColumn('action', function ($model) {
                                return '<a href='.url('service-desk/assetstypes/'.$model->id.'/edit')." class='btn btn-info btn-xs'>Edit</a> ";
                            })
                            ->searchColumns('name', 'created_at', 'updated_at')
                            ->orderColumns('name', 'created_at', 'updated_at')
                            ->make();
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * @return type
     */
    public function create()
    {
        try {
            $types = SdAssettypes::lists('name', 'id')->toArray();
            $forms = Form::lists('title', 'id')->toArray();

            return view('service::assetstypes.create', compact('forms', 'types'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * @param CreateAssetstypesRequest $request
     *
     * @return type
     */
    public function handleCreate(CreateAssetstypesRequest $request)
    {
        try {
            $sd_assetstypes = new SdAssettypes();
            $sd_assetstypes->fill($request->input())->save();
            $formid = $request->input('form');
            $save = $this->saveForm($sd_assetstypes->id, $formid);

            return \Redirect::route('service-desk.assetstypes.index')->with('message', 'Assets Types successfully create !!!');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * @param type $id
     *
     * @return type
     */
    public function edit($id)
    {
        try {
            $type = SdAssettypes::findOrFail($id);
            $forms = Form::lists('title', 'id')->toArray();
            $types = SdAssettypes::lists('name', 'id')->toArray();

            return view('service::assetstypes.edit', compact('type', 'forms', 'types'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function handleEdit($id, CreateAssetstypesRequest $request)
    {
        try {
            $formid = $request->input('form');
            $sd_assets_types = SdAssettypes::findOrFail($id);
            if ($sd_assets_types) {
                $sd_assets_types->fill($request->input())->save();

                $save = $this->saveForm($sd_assets_types->id, $formid);

                return \Redirect::route('service-desk.assetstypes.index')->with('message', 'Assets Types successfully Edit !!!');
            }

            throw new Exception('we can not find your request');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * @param type $id
     *
     * @return type
     */
    public function assetHandledelete($id)
    {
        try {
            $sd_assets_types = SdAssettypes::findOrFail($id);
            if ($sd_assets_types) {
                $sd_assets_types->delete();

                return \Redirect::route('service-desk.assetstypes.index')->with('message', 'Assets Types successfully delete !!!');
            }

            throw new Exception('We can not find your request');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function saveForm($typeid, $formid)
    {
        $relation = new AssetFormRelation();
        $relations = $relation->where('asset_type_id', $typeid)->first();
        if ($relations) {
            $relation = $relations;
        }
        if ($formid) {
            $relation->asset_type_id = $typeid;
            $relation->form_id = $formid;
            $relation->save();
        }

        return 'success';
    }

    public function renderForm(Request $request, $assetid = '')
    {
        $form = '';
        $id = $request->input('asset_type');
        $form_controller = new FormBuilderController();
        $ids = $this->getAssetTypeWithParent($id);
        //dd($ids);
        foreach ($ids as $id) {
            $form .= $form_controller->renderHtmlByFormId($id, false, $assetid);
        }

        return $form;
    }

    public function getAssetTypeWithParent($id)
    {
        $types = new SdAssettypes();
        $type = $types->find($id);

        $parent = [];
        if ($type) {
            $parent[] = $id;
            if ($type->parent_id) {
                $parent = array_merge($parent, $this->doWhile($type->parent_id));
            }
        }

        return $parent;
    }

    public function doWhile($id)
    {
        $parent = '';
        do {
            $parent = $this->getAssetTypeWithParent($id);
        } while ($id === '0');

        return $parent;
    }
}
