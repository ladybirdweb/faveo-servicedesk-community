<?php

namespace App\Plugins\ServiceDesk\Model;

use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
{
    protected $table = 'sd_attachments';
    protected $fillable = ['id', 'name', 'created_at', 'updated_at',

    ];
}
