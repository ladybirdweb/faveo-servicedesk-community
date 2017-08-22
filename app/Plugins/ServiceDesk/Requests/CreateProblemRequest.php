<?php

namespace App\Plugins\ServiceDesk\Requests;

use App\Http\Requests\Request;

class CreateProblemRequest extends Request
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

            'from'           => 'required|email',
            'description'    => 'required',
            'department'     => 'required',
            'status_type_id' => 'required',
            'subject'        => 'required',
//            'priority_id' => 'required',
//            'impact_id' => 'required',
//            'location_type_id' => 'required',
//            'group_id' => 'required',
//            'agent_id' => 'required',
//            'assigned_id' => 'required',
                ];
    }

    public function messages()
    {
        return [

            'from.required' => 'From Required',

            'description.required'      => 'Description Required',
            'department.required'       => 'Department Required',
            'status_type_id.required'   => 'Status Type Required',
            'priority_id.required'      => 'Priority Required',
            'impact_id.required'        => 'impact Required',
            'location_type_id.required' => 'Location Type required',
            'group_id.required'         => 'Group Required',
            'agent_id.required'         => 'Agent Required',
            'assigned_id.required'      => 'Assigned Required',
        ];
    }
}
