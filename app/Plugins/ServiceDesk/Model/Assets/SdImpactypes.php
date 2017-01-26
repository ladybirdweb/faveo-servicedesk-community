<?php

namespace App\Plugins\ServiceDesk\Model\Assets;
use Illuminate\Database\Eloquent\Model;

class SdImpactypes extends Model
{
    protected $table = 'sd_impact_types';
    protected $fillable = ['id','name','created_at','updated_at'];
}
