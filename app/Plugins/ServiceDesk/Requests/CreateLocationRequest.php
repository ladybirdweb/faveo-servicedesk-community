<?php

namespace App\Plugins\ServiceDesk\Requests;

use App\Http\Requests\Request;

class CreateLocationRequest extends Request
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
            'title'             => 'required',
            'email'             => 'required',
            'phone'             => 'required',
            'address'           => 'required',
            'location_category' => 'required',
            'department'        => 'required',

        ];
    }
}
