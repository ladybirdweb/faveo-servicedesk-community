<?php

namespace App\Plugins\ServiceDesk\Controllers\Procurment;

use App\Plugins\ServiceDesk\Controllers\BaseServiceDeskController;
use App\Plugins\ServiceDesk\Model\Procurment\SdProcurment;
use App\Plugins\ServiceDesk\Requests\CreateProcurmentRequest;
use Exception;

class ProcurmentController extends BaseServiceDeskController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            return view('service::procurment.index');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function getProcurment()
    {
        try {
            $procurment = new SdProcurment();
            $procurments = $procurment->select('id', 'name')->get();

            return \Datatable::Collection($procurments)
                            ->showColumns('name')
                            ->addColumn('Action', function ($model) {
                                return '<a href='.url('service-desk/procurement/'.$model->id.'/edit')." class='btn btn-info btn-xs'>Edit</a> ";
                                //. "<a href=" . url('service-desk/procurement/' . $model->id . '/delete') . " class='btn btn-warning btn-xs btn-flat'>Delete</a>";
                            })
                            ->searchColumns('name')
                            ->orderColumns('name')
                            ->make();
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('service::procurment.create', compact('name'));
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function handleCreate(CreateProcurmentRequest $request)
    {
        try {
            // dd($request);
            $sd_procurment = new SdProcurment();
            $sd_procurment->fill($request->input())->save();

            return \Redirect::route('service-desk.procurment.index')->with('message', 'Procurment Successfully Create !!!');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function delete($id)
    {
        $sd_procurments = SdProcurment::findOrFail($id);

        $sd_procurments->delete();

        return \Redirect::route('service-desk.procurment.index')->with('message', 'Contract successfully delete');
    }

    public function edit($id)
    {
        try {
            $procurement = SdProcurment::findOrFail($id);
            if ($procurement) {
                return view('service::procurment.edit', compact('procurement'));
            }

            throw new Exception('We can not find your request');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function handleEdit($id, CreateProcurmentRequest $request)
    {
        try {
            $sd_procurments = SdProcurment::findOrFail($id);
            if ($sd_procurments) {
                $sd_procurments->name = $request->name;
                $sd_procurments->save();

                return \Redirect::route('service-desk.procurment.index')->with('message', 'Contract successfully edit');
            }

            throw new Exception('We can not find your request');
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage);
        }
    }
}
