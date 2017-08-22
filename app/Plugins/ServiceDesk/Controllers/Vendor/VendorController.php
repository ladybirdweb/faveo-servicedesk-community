<?php

namespace App\Plugins\ServiceDesk\Controllers\Vendor;

use App\Plugins\ServiceDesk\Controllers\BaseServiceDeskController;
use App\Plugins\ServiceDesk\Model\Vendor\SdVendors;
use App\Plugins\ServiceDesk\Requests\CreateVendorRequest;
use Exception;

class VendorController extends BaseServiceDeskController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            return view('service::vendor.index');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function getVendors()
    {
        try {
            $vandors = new SdVendors();
            $vandor = $vandors->select('id', 'name', 'primary_contact', 'email', 'description', 'address', 'status')->get();

            return \Datatable::Collection($vandor)
                            ->showColumns('name', 'primary_contact', 'email', 'address')
                            ->addColumn('status', function ($model) {
                                $status = 'Inactive';
                                if ($model->status == 1) {
                                    $status = 'Active';
                                }

                                return $status;
                            })
                            ->addColumn('Action', function ($model) {
                                $url = url('service-desk/vendor/'.$model->id.'/delete');
                                $delete = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::deletePopUp($model->id, $url, "Delete $model->subject");

                                return '<a href='.url('service-desk/vendor/'.$model->id.'/edit')." class='btn btn-info btn-sm'>Edit</a> "
                                        .$delete
                                        .' <a href='.url('service-desk/vendor/'.$model->id.'/show')." class='btn btn-primary btn-sm'>View</a>";

                                //return "<a href=" . url('service-desk/vendor/' . $model->id . '/edit') . " class='btn btn-info btn-xs'>Edit</a> <a href=" . url('service-desk/vendor/' . $model->id . '/delete') . " class='btn btn-warning btn-xs btn-flat'>Delete</a>";
                            })
                            ->searchColumns('name', 'primary_contact')
                            ->orderColumns('name', 'primary_contact', 'email', 'description', 'address', 'all_department', 'status')
                            ->make();
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('service::vendor.create');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function handleCreate(CreateVendorRequest $request, $return = false)
    {
        try {
            $sd_vendors = new SdVendors();
            $sd_vendors->name = $request->name;
            $sd_vendors->email = $request->email;
            $sd_vendors->description = $request->description;
            $sd_vendors->primary_contact = $request->primary_contact;
            $sd_vendors->address = $request->address;
            //$sd_vendors->all_department=$request->all_department;
            $sd_vendors->status = $request->status;
            $sd_vendors->save();
            if ($return == false) {
                return \Redirect::route('service-desk.vendor.index')->with('message', 'Vendor Successfully Create !!!');
            }

            return $sd_vendors;
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $vendor = SdVendors::findOrFail($id);

            return view('service::vendor.edit', compact('vendor'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function handleEdit($id, CreateVendorRequest $request)
    {
        try {
            $sd_vendors = SdVendors::findOrFail($id);
            $sd_vendors->name = $request->name;
            $sd_vendors->email = $request->email;
            $sd_vendors->description = $request->description;
            $sd_vendors->primary_contact = $request->primary_contact;
            $sd_vendors->address = $request->address;
            //$sd_vendors->all_department=$request->all_department;
            $sd_vendors->status = $request->status;
            $sd_vendors->save();

            return \Redirect::route('service-desk.vendor.index')->with('message', 'Vendor successfully edit !!!');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $sd_vendors = SdVendors::findOrFail($id);
            $sd_vendors->delete();

            return \Redirect::route('service-desk.vendor.index')->with('message', 'Vendor Successfully Delete !!!');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $vendors = new SdVendors();
            $vendor = $vendors->find($id);
            if ($vendor) {
                return view('service::vendor.show', compact('vendor'));
            } else {
                throw new \Exception('Sorry we can not find your request');
            }
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }
}
