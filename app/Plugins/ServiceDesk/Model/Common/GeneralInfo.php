<?php

namespace App\Plugins\ServiceDesk\Model\Common;

use Illuminate\Database\Eloquent\Model;

class GeneralInfo extends Model
{
    protected $table = 'sd_gerneral';
    protected $fillable = ['owner', 'key', 'value'];
}
