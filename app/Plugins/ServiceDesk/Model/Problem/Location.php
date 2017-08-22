<?php

namespace App\Plugins\ServiceDesk\Model\Problem;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'sd_locations';
    protected $fillable = ['id', 'name', 'created_at', 'updated_at',

    ];
}
