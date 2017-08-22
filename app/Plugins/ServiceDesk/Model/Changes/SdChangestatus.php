<?php

namespace App\Plugins\ServiceDesk\Model\Changes;

use Illuminate\Database\Eloquent\Model;

class SdChangestatus extends Model
{
    protected $table = 'sd_change_status';
    protected $fillable = ['id', 'name', 'created_at', 'updated_at'];
}
