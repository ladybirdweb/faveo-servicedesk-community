<?php

namespace App\Itil\Models\Problem;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'sd_locations';
    protected $fillable = ['id', 'name', 'created_at', 'updated_at',

    ];
}
