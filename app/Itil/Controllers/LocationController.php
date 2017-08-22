<?php

namespace App\Itil\Controllers;

use App\Itil\Models\Changes\SdLocationcategories;
use App\Itil\Models\Common\Location;
use App\Itil\Requests\CreateLocationRequest;
use App\Model\helpdesk\Agent\Department;
use Exception;
use Illuminate\Http\Request;

class LocationController extends BaseServiceDeskController
{
    /**
     * @return type
     */
    public function index()
    {
        try {
            return view('itil::location.index');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * @return type
     */
    public function getLocation()
    {
        try {
            $locationcategorys = new Location();
            $locationcategory = $locationcategorys->select('id', 'location_category_id', 'title', 'email', 'phone', 'address', 'all_department_access', 'departments', 'status', 'created_at', 'updated_at')->get();

            return \Datatable::Collection($locationcategory)
                            ->addColumn('location_category_id', function ($model) {
                                $name = '--';
                                $location_categories = new SdLocationcategories();
                                $location_category = $location_categories->where('id', $model->location_category_id)->first();
                                if ($location_category) {
                                    $name = $location_category->name;
                                }

                                return $name;
                            })
                            ->showColumns('title', 'email', 'phone', 'address')
                            ->addColumn('action', function ($model) {
                                return '<a href='.url('service-desk/location-types/'.$model->id.'/edit')." class='btn btn-info btn-sm'>Edit</a> <a href=".url('service-desk/location-types/'.$model->id.'/show')." class='btn btn-primary btn-sm'>View</a>";
                            })
                            ->searchColumns('title', 'email', 'phone', 'address')
                            ->orderColumns('location_category_id', 'title', 'email', 'phone', 'address')
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
            $departments = Department::all(['id', 'name']);
            $location_category = SdLocationcategories::all(['id', 'name']);
            $organizations = \App\Model\helpdesk\Agent_panel\Organization::lists('name', 'id')->toArray();

            return view('itil::location.create', compact('departments', 'location_category', 'organizations'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * @param CreateLocationRequest $request
     *
     * @return type
     */
    public function handleCreate(CreateLocationRequest $request)
    {
        try {
            $sd_location = new Location();
            $sd_location->title = $request->title;
            $sd_location->email = $request->email;
            $sd_location->phone = $request->phone;
            $sd_location->address = $request->address;
            $sd_location->location_category_id = $request->location_category;
            $sd_location->departments = $request->department;
            $sd_location->organization = $request->organization;
            $sd_location->save();

            return \Redirect::route('service-desk.location.index')->with('message', 'Location successfully created');
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
            // dd($id);
            $location_category_name = '';
            $departments_name = '';
            $sd_location = Location::findOrFail($id);
            $departments = Department::whereid($sd_location->departments)->first();
            if ($departments) {
                $departments_name = $departments->name;
            }
            $location_category = SdLocationcategories::whereid($sd_location->location_category_id)->first();
            if ($location_category) {
                $location_category_name = $location_category->name;
            }
            $departments = Department::all(['id', 'name']);
            $location_category = SdLocationcategories::all(['id', 'name']);
            $organizations = \App\Model\helpdesk\Agent_panel\Organization::lists('name', 'id')->toArray();

            return view('itil::location.edit', compact('departments', 'location_category', 'location_category_name', 'departments_name', 'sd_location', 'organizations'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * @param CreateLocationRequest $request
     *
     * @return type
     */
    public function handleEdit(CreateLocationRequest $request)
    {
        try {
            $id = $request->location_id;
            $sd_location = Location::findOrFail($id);
            $sd_location->email = $request->email;
            $sd_location->title = $request->title;
            $sd_location->phone = $request->phone;
            $sd_location->address = $request->address;
            $sd_location->location_category_id = $request->location_category;
            $sd_location->departments = $request->department;
            $sd_location->organization = $request->organization;
            $sd_location->save();

            return \Redirect::route('service-desk.location.index')->with('message', 'Location  successfully Updated');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * @param type $id
     *
     * @return type
     */
    public function handledelete($id)
    {
        try {
            $sd_location = Location::findOrFail($id);
            $sd_location->delete();

            return \Redirect::route('service-desk.location-category.index')->with('message', 'Location  successfully delete !!!');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $locations = new Location();
            $location = $locations->find($id);
            if ($location) {
                return view('itil::location.show', compact('location'));
            } else {
                throw new \Exception('Sorry we can not find your request');
            }
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function getLocationsForForm(Request $request)
    {
        $id = $request->input('id');
        $assets = new \App\Itil\Model\Assets\SdAssets();
        $asset = $assets->find($id);
        $location_id = '';
        $select = '';
        if ($asset) {
            $location_id = $asset->location_id;
        }
        $html = "<option value=''>Select</option>";
        $orgid = $request->input('org');
        $location = $this->getLocationsByOrg($orgid);
        $locations = $location->lists('title', 'id')->toArray();
        if (count($locations) > 0) {
            foreach ($locations as $key => $value) {
                if ($key == $location_id) {
                    $select = 'selected';
                }
                $html .= "<option value='".$key."' $select>".$value.'</option>';
            }
        }

        return $html;
    }

    public function getLocationsByOrg($orgid)
    {
        $location = new Location();
        $locations = $location->where('organization', $orgid);

        return $locations;
    }
}
