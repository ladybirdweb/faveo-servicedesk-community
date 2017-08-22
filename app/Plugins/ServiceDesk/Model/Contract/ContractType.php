<?php

namespace App\Plugins\ServiceDesk\Model\Contract;

use Illuminate\Database\Eloquent\Model;

class ContractType extends Model
{
    protected $table = 'sd_contract_types';
    protected $fillable = ['id', 'name', 'created_at', 'updated_at',

    ];
}
