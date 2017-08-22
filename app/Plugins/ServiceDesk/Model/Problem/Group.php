<?php

namespace App\Plugins\ServiceDesk\Model\Problem;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'sd_group_types';
    protected $fillable = ['id', 'name', 'created_at', 'updated_at',

    ];
}
