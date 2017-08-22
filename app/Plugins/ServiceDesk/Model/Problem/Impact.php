<?php

namespace App\Plugins\ServiceDesk\Model\Problem;

use Illuminate\Database\Eloquent\Model;

class Impact extends Model
{
    protected $table = 'sd_impact_types';
    protected $fillable = ['id', 'saved', 'created_at', 'updated_at',

    ];
}
