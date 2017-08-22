<?php

namespace App\Itil\Models\Changes;

use Illuminate\Database\Eloquent\Model;

class SdChangetypes extends Model
{
    protected $table = 'sd_change_types';
    protected $fillable = ['id', 'name', 'created_at', 'updated_at'];
}
