<?php

namespace App\Plugins\ServiceDesk\Model\Assets;

use Illuminate\Database\Eloquent\Model;

class SdAssettypes extends Model
{
    protected $table = 'sd_asset_types';
    protected $fillable = ['id', 'name', 'parent_id', 'created_at', 'updated_at'];
}
