<?php

namespace App\Plugins\ServiceDesk\Model\Problem;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $table = 'sd_agent_types';
    protected $fillable = ['id', 'name', 'created_at', 'updated_at',

    ];
}
