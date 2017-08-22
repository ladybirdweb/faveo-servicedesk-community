<?php

namespace App\Plugins\ServiceDesk\Model\Releases;

use Illuminate\Database\Eloquent\Model;

class SdLocations extends Model
{
    protected $table = 'sd_locations';
    protected $fillable = ['id', 'location_category_id', 'title', 'email', 'phone', 'address', 'all_department_access', 'departments', 'status', 'created_at', 'updated_at'];
}
