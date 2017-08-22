<?php

namespace App\Plugins\ServiceDesk\Model\FormBuilder;

use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    protected $table = 'sd_form_fields';
    protected $fillable = [
        'name',
        'label',
        'form_id',
        'type',
        'sub_type',
        'class',
        'is_required',
        'placeholder',
        'description',
        'multiple',
        'role',
    ];

    public function fieldValue()
    {
        return $this->hasMany('App\Plugins\ServiceDesk\Model\FormBuilder\FormValue', 'field_id');
    }

    public function delete()
    {
        $this->fieldValue()->delete();
        parent::delete();
    }
}
