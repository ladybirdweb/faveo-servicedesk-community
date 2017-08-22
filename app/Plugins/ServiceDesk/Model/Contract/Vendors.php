<?php

namespace App\Plugins\ServiceDesk\Model\Contract;

use Illuminate\Database\Eloquent\Model;

class Vendors extends Model
{
    protected $table = 'sd_vendors';
    protected $fillable = ['id', 'name', 'primarycontact', 'email', 'description', 'address', 'all_department', 'status', 'created_at', 'updated_at',

    ];
}
