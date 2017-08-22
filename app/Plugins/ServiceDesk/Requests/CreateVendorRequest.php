<?php

namespace App\Plugins\ServiceDesk\Requests;

use App\Http\Requests\Request;

class CreateVendorRequest extends Request
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

             'name'           => 'required',
            'primary_contact' => 'required',
            'email'           => 'required',
//            'description' => 'required',
            'address' => 'required',
//            'all_department' => 'required',
            'status' => 'required',
        ];
    }
}
