<?php

namespace App\Plugins\ServiceDesk\Model\Problem;

use Illuminate\Database\Eloquent\Model;

class SdStatusTypes extends Model
{
    protected $table = 'sd_status_types';
    protected $fillable = ['id', 'name', 'created_at', 'updated_at',

    ];
}
