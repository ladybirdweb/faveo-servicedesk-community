<?php

namespace App\Plugins\ServiceDesk\Model\Assets;
use Illuminate\Database\Eloquent\Model;

class AssetFormRelation extends Model
{
    protected $table = 'sd_asset_type_form';
    protected $fillable = [
        'asset_type_id',
        'form_id',
    ];
}
