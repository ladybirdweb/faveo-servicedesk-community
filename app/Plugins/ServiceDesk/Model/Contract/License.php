<?php

namespace App\Plugins\ServiceDesk\Model\Contract;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    protected $table = 'sd_license_types';
    protected $fillable = ['id','name','created_at','updated_at',
        
    ];


  
}