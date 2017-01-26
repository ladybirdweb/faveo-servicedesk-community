<?php

namespace App\Plugins\ServiceDesk\Model\Releases;
use Illuminate\Database\Eloquent\Model;

class SdReleasestatus extends Model
{
    protected $table = 'sd_release_status';
    
   protected $fillable = ['id','name','created_at','updated_at'];
}