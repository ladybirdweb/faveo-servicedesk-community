<?php

namespace App\Plugins\ServiceDesk\Model\Procurment;

use Illuminate\Database\Eloquent\Model;

class SdProcurment extends Model
{
    protected $table = 'sd_product_proc_mode';
    protected $fillable = ['id', 'name', 'created_at', 'updated_at',

    ];
}
