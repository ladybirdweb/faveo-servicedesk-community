<?php

namespace App\Itil\Controllers;

use App\Itil\Models\Changes\SdLocationcategories;
use App\Itil\Requests\CreateLocationcatagoryRequest;
use Exception;

class LocationCategoryController extends BaseServiceDeskController
{
    public function index()
    {
        try {
            return view('itil::locationcategory.index');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function getLocation()
    {
        try {
            //dd('s');
            $locationcategorys = new SdLocationcategories();
            $locationcategory = $locationcategorys->select('id', 'name', 'parent_id', 'created_at', 'updated_at')->get();

            return \Datatable::Collection($locationcategory)
                            ->showColumns('name', 'created_at', 'updated_at')
                            ->addColumn('action', function ($model) {
                                $url = url('service-desk/location-category-types/'.$model->id.'/delete');
                                $delete = \App\Itil\Controllers\UtilityController::deletePopUp($model->id, $url, "Delete $model->subject", 'btn btn-danger btn-sm');

                                return '<a href='.url('service-desk/location-category-types/'.$model->id.'/edit')." class='btn btn-info btn-sm'>Edit</a>"
                                        .$delete;
                            })
                            ->searchColumns('name')
                            ->orderColumns('name', 'created_at', 'updated_at')
                            ->make();
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('itil::locationcategory.create');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function handleCreate(CreateLocationcatagoryRequest $request)
    {
        try {
            $sd_location_catagory = new SdLocationcategories();
            $sd_location_catagory->fill($request->input())->save();

            return \Redirect::route('service-desk.location-category.index')->with('message', 'Location Category  successfully create !!!');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $sd_location_catagory = SdLocationcategories::findOrFail($id);
            if ($sd_location_catagory) {
                return view('itil::locationcategory.edit', compact('sd_location_catagory'));
            }

            throw new Exception('We can not find your request');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function handleEdit($id, CreateLocationcatagoryRequest $request)
    {
        try {
            $sd_location_catagory = SdLocationcategories::findOrFail($id);
            if ($sd_location_catagory) {
                $sd_location_catagory->fill($request->input())->save();

                return \Redirect::route('service-desk.location-category.index')->with('message', 'Location Category successfully Edit !!!');
            }

            throw new Exception('We can not find your request');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function handledelete($id)
    {
        try {
            $sd_location_catagory = SdLocationcategories::findOrFail($id);
            if ($sd_location_catagory) {
                $sd_location_catagory->delete();

                return \Redirect::route('service-desk.location-category.index')->with('message', 'Location Category successfully delete !!!');
            }

            throw new Exception('We can not find your request');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }
}
