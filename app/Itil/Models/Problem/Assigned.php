<?php

namespace App\Itil\Models\Problem;

use Illuminate\Database\Eloquent\Model;

class Assigned extends Model
{
    protected $table = 'sd_assigned_types';
    protected $fillable = ['id', 'name', 'created_at', 'updated_at',

    ];
}
