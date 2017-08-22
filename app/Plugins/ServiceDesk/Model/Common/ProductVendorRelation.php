<?php

namespace App\Plugins\ServiceDesk\Model\Common;

use Illuminate\Database\Eloquent\Model;

class ProductVendorRelation extends Model
{
    protected $table = 'sd_product_vendor_relation';
    protected $fillable = ['product_id', 'vendor_id'];
}
