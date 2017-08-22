<?php

namespace App\Plugins\ServiceDesk\Model\Contract;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'sd_products';
    protected $fillable = ['id', 'name', 'description', 'manufacture', 'asset_type_id', 'product_status_id', 'product_mode_procurement_id', 'all_department', 'created_at', 'updated_at',

    ];
}
