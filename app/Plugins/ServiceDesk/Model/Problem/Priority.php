<?php

namespace App\Plugins\ServiceDesk\Model\Problem;

use Illuminate\Database\Eloquent\Model;



class Priority extends Model
{
    protected $table = 'sd_priority_types';
    protected $fillable = ['id','name','contract_end_date','created_at','updated_at',
        
    ];
}
