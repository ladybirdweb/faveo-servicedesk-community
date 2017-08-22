<?php

namespace App\Plugins\ServiceDesk\Requests;

use App\Http\Requests\Request;

class CreateContractRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

             'name'             => 'required',
             'description'      => 'required',
             'contract_type_id' => 'required',
             'product_id'       => 'required',

        ];
    }

    public function messages()
    {
        return [

             'name.required'                => 'Name Required',
             'description.required'         => 'Description Required',
             'cost.required'                => 'Cost Required',
             'contract_type_id.required'    => 'Contract Type Required',
             'approver_id.required'         => 'Approver Required',
             'vendor_id.required'           => 'Vendor Required',
             'license_type_id.required'     => 'License Type Required',
             'licensce_count.required'      => 'licensce Count Required',
             'notify_expiry.required'       => 'Notify Expiry Required',
             'product_id.required'          => 'Product Required',
             'contract_start_date.required' => 'Contract Start Date Required',
             'contract_end_date.required'   => 'Contract End Date Required',
        ];
    }
}
