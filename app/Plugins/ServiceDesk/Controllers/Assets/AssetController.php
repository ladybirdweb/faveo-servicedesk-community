<?php

namespace App\Plugins\ServiceDesk\Controllers\Assets;

use App\Model\helpdesk\Agent\Department;
use App\Plugins\ServiceDesk\Controllers\BaseServiceDeskController;
use App\Plugins\ServiceDesk\Model\Assets\AssetForm;
use App\Plugins\ServiceDesk\Model\Assets\SdAssets;
use App\Plugins\ServiceDesk\Model\Assets\SdAssettypes;
use App\Plugins\ServiceDesk\Model\Assets\SdImpactypes;
use App\Plugins\ServiceDesk\Model\Assets\SdLocations;
use App\Plugins\ServiceDesk\Model\Products\SdProducts;
use App\Plugins\ServiceDesk\Requests\CreateAssetRequest;
use App\User;
use Exception;
use Illuminate\Http\Request;

class AssetController extends BaseServiceDeskController
{
    public function index()
    {
        try {
            return view('service::assets.index');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * @return type
     */
    public function getAsset()
    {
        try {
            $asset = new SdAssets();
            $assets = $asset->select('id', 'name', 'description', 'department_id', 'asset_type_id', 'impact_type_id', 'managed_by', 'used_by', 'location_id', 'assigned_on')->get();

            return \Datatable::Collection($assets)
                            ->showColumns('name')
                            ->addColumn('managed_by', function ($model) {
                                $managed = new User();
                                $managed_name = $managed->where('id', $model->managed_by)->first()->email;

                                return $managed_name;
                            })
                            ->addColumn('used_by', function ($model) {
                                $used = new User();
                                $used_by_name = $used->where('id', $model->used_by)->first()->email;

                                return $used_by_name;
                            })
                            // ->showColumns('assigned_on')
                            ->addColumn('action', function ($model) {
                                $url = url('service-desk/assets/'.$model->id.'/delete');
                                $delete = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::deletePopUp($model->id, $url, "Delete $model->subject");

                                return '<a href='.url('service-desk/assets/'.$model->id.'/edit')." class='btn btn-info btn-sm'>Edit</a> "
                                        .$delete
                                        .' <a href='.url('service-desk/assets/'.$model->id.'/show')." class='btn btn-primary btn-sm'>View</a>";
                            })
                            ->searchColumns('name', 'department_id', 'asset_type_id', 'impact_type_id', 'managed_by', 'used_by', 'location_id')
                            ->orderColumns('description', 'subject', 'reason', 'impact', 'rollout_plan', 'backout_plan', 'status_id', 'priority_id', 'change_type_id', 'impact_id', 'location_id', 'approval_id')
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
            $sd_impact_types = SdImpactypes::lists('name', 'id')->toArray();
            $sd_asset_types = SdAssettypes::lists('name', 'id')->toArray();
            $departments = Department::lists('name', 'id')->toArray();
            $products = SdProducts::lists('name', 'id')->toArray();
            $users = User::where('role', 'admin')->orWhere('role', 'agent')->lists('email', 'id')->toArray();
            $sd_locations = SdLocations::lists('title', 'id')->toArray();
            $organizations = \App\Model\helpdesk\Agent_panel\Organization::lists('name', 'id')->toArray();

            return view('service::assets.create', compact('organizations', 'products', 'sd_impact_types', 'sd_asset_types', 'users', 'departments', 'sd_locations'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * @param CreateAssetRequest $request
     *
     * @return type
     */
    public function handleCreate(CreateAssetRequest $request)
    {
        try {
            $sd_assets = new SdAssets();
            $sd_assets->fill($request->input())->save();
            $this->saveExternalId($sd_assets);
            \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::attachment($sd_assets->id, 'sd_assets', $request->file('attachments'));
            $form = $request->except('organization', 'external_id', 'product_id', '_token', 'name', 'description', 'department_id', 'asset_type_id', 'impact_type_id', 'managed_by', 'used_by', 'location_id', 'assigned_on');
            $this->storeAssetForm($sd_assets->id, $form);
            $result = ['success' => "Asset $sd_assets->name created successfully"];

            return response()->json(compact('result'));
            //return \Redirect::route('service-desk.asset.index')->with('message', 'Asset successfully create !!!');
        } catch (Exception $ex) {
            dd($ex);
            $result = ['fails' => $ex->getMessage()];

            return response()->json(compact('result'));
            //return redirect()->back()->with('fails', $ex->getMessage());
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
            $asset = SdAssets::find($id);
            $sd_impact_types = SdImpactypes::lists('name', 'id')->toArray();
            $sd_asset_types = SdAssettypes::lists('name', 'id')->toArray();
            $departments = Department::lists('name', 'id')->toArray();
            $products = SdProducts::lists('name', 'id')->toArray();
            $users = User::where('role', 'admin')->orWhere('role', 'agent')->lists('email', 'id')->toArray();
            $sd_locations = SdLocations::lists('title', 'id')->toArray();
            $organizations = \App\Model\helpdesk\Agent_panel\Organization::lists('name', 'id')->toArray();

            return view('service::assets.edit', compact('organizations', 'products', 'sd_impact_types', 'sd_asset_types', 'users', 'departments', 'sd_locations', 'asset'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * @param CreateAssetRequest $request
     *
     * @return type
     */
    public function handleEdit($id, CreateAssetRequest $request)
    {
        try {
            $sd_assets = SdAssets::findOrFail($id);
            $sd_assets->fill($request->input())->save();
            $this->saveExternalId($sd_assets);
            \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::attachment($sd_assets->id, 'sd_assets', $request->file('attachments'));
            $form = $request->except('organization', 'external_id', 'product_id', '_token', 'name', 'description', 'department_id', 'asset_type_id', 'impact_type_id', 'managed_by', 'used_by', 'location_id', 'assigned_on');
            $this->storeAssetForm($sd_assets->id, $form);
            $result = ['success' => "Asset $sd_assets->name updated successfully"];

            return response()->json(compact('result'));
            //return \Redirect::route('service-desk.asset.index')->with('message', 'Asset successfully Edit !!!');
        } catch (Exception $ex) {
            $result = ['fails' => $ex->getMessage()];

            return response()->json(compact('result'));
            //return redirect()->back()->with('fails', $ex->getMessage());
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
            $sd_assets = SdAssets::findOrFail($id);
            $sd_assets->delete();

            return \Redirect::route('service-desk.asset.index')->with('message', 'Asset successfully delete !!!');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * @param Request $request
     *
     * @return type
     */
    public function search(Request $request)
    {
        try {
            $format = $request->input('format');
            $query = $request->input('query');
            $assets = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::assetSearch($query, $format);

            return $assets;
        } catch (Exception $ex) {
        }
    }

    /**
     * @param Request $request
     *
     * @return type
     */
    public function attachAssetToTicket(Request $request)
    {
        try {
            $assetid = $request->input('asset');
            $threadid = $request->input('tiketid');
            $ticket = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::getTicketByThreadId($threadid);
            $ticketid = $ticket->id;
            //dd($ticketid);
            \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::saveTicketRelation($ticketid, 'sd_assets', $assetid);
            \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::saveAssetRelation($assetid, 'tickets', $ticketid);
            //if ($relation) {
            return redirect()->back()->with('success', 'Asset added successfully');
            //}
        } catch (Exception $ex) {
            dd($ex);

            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * @param Request $request
     *
     * @return type
     */
    public function assetType(Request $request)
    {
        try {
            $asset_type_id = $request->input('asset_type');

            return \Datatable::table()
                            ->addColumn('#', 'Assets', 'Used By')
                            ->setUrl(url('service-desk/asset-type/'.$asset_type_id))
                            ->render();
        } catch (Exception $ex) {
        }
    }

    /**
     * @param type $id
     *
     * @return type
     */
    public function getAssetType($id)
    {
        $assets = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::assetByTypeId($id);

        return $this->createChumper($assets);
    }

    public function createChumper($model, $select = [])
    {
        try {
            $collection = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::getModelWithSelect($model, $select);

            return \Datatable::Collection($collection->get())
                            ->addColumn('id', function ($model) {
                                return \Form::radio('asset', $model->id);
                            })
                            ->showColumns('name')
                            ->addColumn('used_by', function ($model) {
                                $users = new \App\User();
                                $user = $users->find($model->used_by);

                                return $user->first_name.' '.$user->last_name;
                            })
                            ->searchColumns('names')
                            ->make();
        } catch (Exception $ex) {
        }
    }

    /**
     * @param type $threadid
     */
    public function timelineMarble($asset, $ticketid)
    {
        if ($asset) {
            echo $this->marble($asset, $ticketid);
        }
        echo '';
    }

    /**
     * @param type $asset
     * @param type $ticketid
     *
     * @return type
     */
    public function marble($asset, $ticketid)
    {
        $user = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::getManagedByAssetId($asset->id);
        $managed = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::getManagedByAssetId($asset->id);
        $asset_name = $asset->name;
        $user_name = $user->first_name.' '.$user->last_name;
        $managed_by = $managed->first_name.' '.$managed->last_name;

        return $this->marbleHtml($ticketid, $asset_name, $user_name, $managed_by, $asset->id);
    }

    /**
     * @param type $ticketid
     * @param type $asset_name
     * @param type $user_name
     * @param type $managed_by
     *
     * @return type
     */
    public function marbleHtml($ticketid, $asset_name, $user_name, $managed_by, $assetid)
    {
        $url = url('service-desk/asset/detach/'.$ticketid);
        $detach_popup = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::deletePopUp($ticketid, $url, 'Delete', ' ', 'Delete', true);

        return "<div class='box box-primary'>"
                ."<div class='box-header'>"
                ."<h3 class='box-title'>Associated Assets</h3>"
                .'</div>'
                ."<div class='box-body row'>"
                ."<div class='col-md-12'>"
                ."<table class='table'>"
                .'<tr>'
                .'<th>'.ucfirst($asset_name).'</th>'
                .'<th><i>Used by: </i> '.ucfirst($user_name).'</th>'
                .'<th><i>Managed by: </i> '.ucfirst($managed_by).'</th>'
                .'<th>'.$detach_popup
                .' | <a href='.url('service-desk/assets/'.$assetid.'/show/').'>View</a></th>'
                .'</table>'
                .'</div>'
                .'</div>'
                .'</div>';
    }

    /**
     * @param type $ticketid
     *
     * @return type
     */
    public function detach($ticketid)
    {
        $relation = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::getRelationOfTicketByTable($ticketid, 'sd_asset');
        if ($relation) {
            $relation->delete();
        }

        return redirect()->back()->with('success', 'Detached successfully');
    }

    public function storeAssetForm($assetid, $request)
    {
        $asset_form = new AssetForm();
        $asset_forms = $asset_form->where('asset_id', $assetid)->get();
        if ($asset_forms->count() > 0) {
            foreach ($asset_forms as $form) {
                $form->delete();
            }
        }
        foreach ($request as $key => $req) {
            $asset_form->create([
                'asset_id' => $assetid,
                'key'      => $key,
                'value'    => $req,
            ]);
        }
    }

    public function getAssetFormContent($id)
    {
        $form_fiedls = new AssetForm();
        $fields = $form_fiedls->where('asset_id', $id)->lists('value', 'key')->toArray();

        return $fields;
    }

    public function show($id)
    {
        try {
            $assets = new SdAssets();
            $asset = $assets->find($id);
            if ($asset) {
                return view('service::assets.show', compact('asset'));
            } else {
                throw new \Exception('Sorry we can not find your request');
            }
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function saveExternalId($asset)
    {
        $extid = \Input::get('external_id');
        if ($extid == '') {
            //dd('yes');
            $asset->external_id = $asset->id;
            $asset->save();
        }
    }

    public function requestersToArray($requesters)
    {
        for ($i = 0; $i < count($requesters); $i++) {
            if (is_object($requesters[$i])) {
                $array[$i]['subject'] = $requesters[$i]->subject();

                $array[$i]['request'] = ucfirst(str_replace('sd_', '', $requesters[$i]->table()));

                $array[$i]['status'] = $requesters[$i]->statuses();

                $array[$i]['created'] = $requesters[$i]->created_at->format('l jS \of F Y h:i:s A');
            }
        }

        return $array;
    }

    public function getRequesters($id)
    {
        $assets = new SdAssets();
        $asset = $assets->find($id);
        $requesters = $asset->requests();
        $array = $this->requestersToArray($requesters);

        return $array;
    }

    public function ajaxRequestTable(Request $request)
    {
        $id = $request->input('assetid');
        $array = $this->getRequesters($id);
        $collection = new \Illuminate\Support\Collection($array);

        return \Datatable::Collection($collection)
                        ->showColumns('subject', 'request', 'status', 'created')
                        ->searchColumns('subject', 'request', 'status', 'created')
                        ->orderColumns('subject', 'request', 'status', 'created')
                        ->make();
    }

    public function export()
    {
        try {
            return view('service::assets.export');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function exportAsset(Request $request)
    {
        try {
            $date = $request->input('date');
            $date = str_replace(' ', '', $date);
            $date_array = explode(':', $date);
            $first = $date_array[0].' 00:00:00';
            $second = $date_array[1].' 23:59:59';
            $first_date = $this->convertDate($first);
            $second_date = $this->convertDate($second);
            $assets = $this->getAssets($first_date, $second_date);
            $excel_controller = new \App\Http\Controllers\Common\ExcelController();
            $filename = 'assets'.$date;
            $excel_controller->export($filename, $assets);
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function convertDate($date)
    {
        $converted_date = date('Y-m-d H:i:s', strtotime($date));

        return $converted_date;
    }

    public function getAssets($first, $last)
    {
        $asset = new SdAssets();
        $assets = $asset->leftJoin('department', 'sd_assets.department_id', '=', 'department.id')
                ->leftJoin('sd_asset_types', 'sd_assets.asset_type_id', '=', 'sd_asset_types.id')
                ->leftJoin('sd_products', 'sd_assets.product_id', '=', 'sd_products.id')
                ->leftJoin('users as used', 'sd_assets.used_by', '=', 'used.id')
                ->leftJoin('users as managed', 'sd_assets.managed_by', '=', 'managed.id')
                ->leftJoin('organization', 'sd_assets.organization', '=', 'organization.id')
                ->leftJoin('sd_locations', 'sd_assets.location_id', '=', 'sd_locations.id')
                ->whereBetween('sd_assets.created_at', [$first, $last])
                ->select('sd_assets.name as Name', 'sd_assets.external_id as Identifier', 'sd_assets.description as Description', 'department.name as Department', 'sd_asset_types.name as Type', 'sd_products.name as Product', 'used.email as Usedby', 'managed.email as Managedby', 'organization.name as Organization', 'sd_locations.title as Location', 'sd_assets.assigned_on as Assignedat')
                ->get()
                ->toArray();

        return $assets;
    }
}
