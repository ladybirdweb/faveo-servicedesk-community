<?php

namespace App\Plugins\ServiceDesk\Model\Changes;

use Illuminate\Database\Eloquent\Model;

class SdLocationcategories extends Model
{
    protected $table = 'sd_location_categories';
    protected $fillable = ['id', 'name', 'parent_id', 'created_at', 'updated_at'];
}
