<?php

namespace App\Plugins\ServiceDesk\Controllers\Licensetypes;

use App\Plugins\ServiceDesk\Controllers\BaseServiceDeskController;
use App\Plugins\ServiceDesk\Model\Contract\License;
use App\Plugins\ServiceDesk\Requests\CreateLicensetypesRequest;
use Exception;

class LicensetypeController extends BaseServiceDeskController
{
    public function index()
    {
        try {
            return view('service::licensetypes.index');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function getLicense()
    {
        try {
            $license_types = new License();
            $license_type = $license_types->select('id', 'name', 'created_at', 'updated_at')->get();

            return \Datatable::Collection($license_type)
                            ->showColumns('name', 'created_at', 'updated_at')
                            ->addColumn('action', function ($model) {
                                return '<a href='.url('service-desk/license-types/'.$model->id.'/edit')." class='btn btn-info btn-xs'>Edit</a>";
                            })
                            ->searchColumns('name', 'created_at', 'updated_at')
                            ->orderColumns('name', 'created_at', 'updated_at')
                            ->make();
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('service::licensetypes.create');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function handleCreate(CreateLicensetypesRequest $request)
    {
        try {
            $sd_licensetypes = new License();
            $sd_licensetypes->fill($request->input())->save();

            return \Redirect::route('service-desk.licensetypes.index')->with('message', 'License Types successfully create !!!');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $licensetype = License::findOrFail($id);
            if ($licensetype) {
                return view('service::licensetypes.edit', compact('licensetype'));
            }

            throw new Exception('We can not find your request');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function handleEdit($id, CreateLicensetypesRequest $request)
    {
        try {
            $sd_licensetypes = License::findOrFail($id);
            if ($sd_licensetypes) {
                $sd_licensetypes->fill($request->input())->save();

                return \Redirect::route('service-desk.licensetypes.index')->with('message', 'License Types successfully Edit !!!');
            }

            throw new Exception('We can not find your request');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function handledelete($id)
    {
        try {
            $sd_licensetypes = License::findOrFail($id);
            if ($sd_licensetypes) {
                $sd_licensetypes->delete();

                return \Redirect::route('service-desk.licensetypes.index')->with('message', 'License Types successfully delete !!!');
            }

            throw new Exception('We can not find your request');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }
}
