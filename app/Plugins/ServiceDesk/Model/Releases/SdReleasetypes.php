<?php

namespace App\Plugins\ServiceDesk\Model\Releases;
use Illuminate\Database\Eloquent\Model;

class SdReleasetypes extends Model
{
    protected $table = 'sd_release_types';
    
   protected $fillable = ['id','name','created_at','updated_at'];
}