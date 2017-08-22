<?php

namespace App\Plugins\ServiceDesk\Model\FormBuilder;

use Illuminate\Database\Eloquent\Model;

class FormValue extends Model
{
    protected $table = 'sd_field_values';
    protected $fillable = [
        'field_id',
        'option',
        'value',

    ];
}
