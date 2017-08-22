<?php

namespace App\Plugins\ServiceDesk\Requests;

use App\Http\Requests\Request;

class CreateProductsRequest extends Request
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
            //
            'name' => 'required',
            //'asset_type' => 'required',
            'manufacturer'        => 'required',
            'Product_status'      => 'required',
            'mode_procurement'    => 'required',
               'department_access'=> 'required',
           'description'          => 'required',
               'status'           => 'required',

        ];
    }
}
