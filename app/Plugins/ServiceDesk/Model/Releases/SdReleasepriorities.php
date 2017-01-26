<?php

namespace App\Plugins\ServiceDesk\Model\Releases;
use Illuminate\Database\Eloquent\Model;

class SdReleasepriorities extends Model
{
    protected $table = 'sd_release_priorities';
    
   protected $fillable = ['id','name','created_at','updated_at'];
}