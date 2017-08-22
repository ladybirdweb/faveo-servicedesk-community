<?php

namespace App\Plugins\ServiceDesk\Requests;

use App\Http\Requests\Request;

class CreateReleaseRequest extends Request
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
            'subject'         => 'required',
            'status_id'       => 'required',
            'priority_id'     => 'required',
            'release_type_id' => 'required',
            'description'     => 'required',

        ];
    }

    public function messages()
    {
        return [
            'status_id.required'      => 'Status Required',
            'priority_id.required'    => 'Priority Required',
            'release_type_id.required'=> 'Release Type Required',
        ];
    }
}
