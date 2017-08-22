<?php

namespace App\Plugins\ServiceDesk\Model\Contract;

use Illuminate\Database\Eloquent\Model;

class Approver extends Model
{
    protected $table = 'sd_aapprover';
    protected $fillable = ['id', 'name', 'created_at', 'updated_at',

    ];
}
