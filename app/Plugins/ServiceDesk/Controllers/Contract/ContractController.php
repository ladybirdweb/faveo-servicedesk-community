<?php

namespace App\Plugins\ServiceDesk\Controllers\Contract;

use App\Plugins\ServiceDesk\Controllers\BaseServiceDeskController;
use App\Plugins\ServiceDesk\Model\Cab\Cab;
use App\Plugins\ServiceDesk\Model\Contract\ContractType;
use App\Plugins\ServiceDesk\Model\Contract\License;
use App\Plugins\ServiceDesk\Model\Contract\Products;
use App\Plugins\ServiceDesk\Model\Contract\SdContract;
use App\Plugins\ServiceDesk\Model\Contract\Vendors;
use App\Plugins\ServiceDesk\Requests\CreateContractRequest;
use Exception;

class ContractController extends BaseServiceDeskController
{
    public function index()
    {
        $sdcontracts = SdContract::all();

        return view('service::contract.index', compact('sdcontracts'));
    }

    public function getContracts()
    {
        try {
            $contract = new SdContract();
            $contracts = $contract->select('id', 'name', 'description', 'cost', 'contract_type_id', 'vendor_id', 'license_type_id', 'licensce_count', 'product_id', 'notify_expiry', 'contract_start_date', 'contract_end_date', 'created_at')->get();

            return \Datatable::Collection($contracts)
                            ->showColumns('name', 'cost')
                            ->addColumn('action', function ($model) {
                                $url = url('service-desk/contracts/'.$model->id.'/delete');
                                $delete = \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::deletePopUp($model->id, $url, "Delete $model->subject");

                                return '<a href='.url('service-desk/contracts/'.$model->id.'/edit')." class='btn btn-info btn-sm'>Edit</a> "
                                        .$delete
                                        .' <a href='.url('service-desk/contracts/'.$model->id.'/show')." class='btn btn-primary btn-sm'>View</a>";
                            })
                            ->searchColumns('name')
                            ->orderColumns('name', 'description', 'cost', 'contract_type_id', 'vendor_id', 'license_type_id', 'licensce_count', 'product_id', 'notify_expiry', 'contract_start_date')
                            ->make();
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    public function create()
    {
        $contract_type_ids = ContractType::lists('name', 'id')->toArray();
        $product_ids = Products::lists('name', 'id')->toArray();
        $license_type_ids = License::lists('name', 'id')->toArray();
        $approvers = Cab::lists('name', 'id')->toArray();
        $vendor_ids = Vendors::lists('name', 'id')->toArray();

        return view('service::contract.create', compact('approvers', 'contract_type_ids', 'product_ids', 'license_type_ids', 'vendor_ids'));
    }

    public function handleCreate(CreateContractRequest $request)
    {
        // dd($request);

        $sd_contracts = new SdContract();
        $sd_contracts->name = $request->name;
        $sd_contracts->description = $request->description;
        $sd_contracts->cost = $request->cost;
        $sd_contracts->contract_type_id = $request->contract_type_id;
        $sd_contracts->approver_id = $request->approver_id;
        $sd_contracts->vendor_id = $request->vendor_id;
        $sd_contracts->license_type_id = $request->license_type_id;
        $sd_contracts->product_id = $request->product_id;
        $sd_contracts->licensce_count = $request->licensce_count;
        $sd_contracts->notify_expiry = $request->notify_expiry;
        $sd_contracts->contract_start_date = $request->contract_start_date;
        $sd_contracts->contract_end_date = $request->contract_end_date;
        $sd_contracts->save();
        $this->sendCab($sd_contracts->id, $request->input('approver_id'));
        \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::attachment($sd_contracts->id, 'sd_contracts', $request->file('attachments'));

        return \Redirect::route('service-desk.contract.index')->with('message', 'Contract successfully create !!!');
    }

    public function delete($id)
    {
        $sdcontract = SdContract::findOrFail($id);
        $sdcontract->delete();

        return \Redirect::route('service-desk.contract.index')->with('message', 'Contract successfully delete !!!');
    }

    public function edit($id)
    {
        $contract = SdContract::findOrFail($id);
        $contract_type_ids = ContractType::lists('name', 'id')->toArray();
        $product_ids = Products::lists('name', 'id')->toArray();
        $license_type_ids = License::lists('name', 'id')->toArray();
        $approvers = Cab::lists('name', 'id')->toArray();
        $vendor_ids = Vendors::lists('name', 'id')->toArray();

        return view('service::contract.edit', compact('contract', 'contract_type_ids', 'approvers', 'product_ids', 'license_type_ids', 'vendor_ids'));
    }

    public function handleEdit($id, CreateContractRequest $request)
    {
        $sd_contracts = SdContract::findOrFail($id);
        $sd_contracts->name = $request->name;
        $sd_contracts->description = $request->description;
        $sd_contracts->cost = $request->cost;
        $sd_contracts->contract_type_id = $request->contract_type_id;
        $sd_contracts->approver_id = $request->approver_id;
        $sd_contracts->vendor_id = $request->vendor_id;
        $sd_contracts->license_type_id = $request->license_type_id;
        $sd_contracts->product_id = $request->product_id;
        $sd_contracts->licensce_count = $request->licensce_count;
        $sd_contracts->notify_expiry = $request->notify_expiry;
        $sd_contracts->contract_start_date = $request->contract_start_date;
        $sd_contracts->contract_end_date = $request->contract_end_date;
        $sd_contracts->save();
        $this->sendCab($sd_contracts->id, $request->input('approver_id'));
        \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::attachment($sd_contracts->id, 'sd_contracts', $request->file('attachments'));

        return \Redirect::route('service-desk.contract.index')->with('message', 'Contract successfully edit !!!');
    }

    public function sendCab($id, $cabid)
    {
        $activity = 'sd_contracts';
        $owner = "$activity:$id";
        $url = url("service-desk/cabs/vote/$cabid/$owner");
        //dd($url);
        \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::cabMessage($cabid, $activity, $url);
    }

    public function show($id)
    {
        try {
            $contracts = new SdContract();
            $contract = $contracts->find($id);
            if ($contract) {
                return view('service::contract.show', compact('contract'));
            } else {
                throw new \Exception('Sorry we can not find your request');
            }
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }
}
