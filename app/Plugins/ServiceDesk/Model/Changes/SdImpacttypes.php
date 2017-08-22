<?php

namespace App\Plugins\ServiceDesk\Model\Changes;

use Illuminate\Database\Eloquent\Model;

class SdImpacttypes extends Model
{
    protected $table = 'sd_impact_types';
    protected $fillable = ['id', 'name', 'created_at', 'updated_at'];
}
