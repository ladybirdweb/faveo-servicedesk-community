<?php

namespace App\Plugins\ServiceDesk\Model\Assets;
use Illuminate\Database\Eloquent\Model;

class AssetForm extends Model
{
    protected $table = 'sd_asset_form';
    protected $fillable = [
        'asset_id',
        'key',
        'value',
    ];
}
