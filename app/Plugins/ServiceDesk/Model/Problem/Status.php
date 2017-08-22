<?php

namespace App\Plugins\ServiceDesk\Model;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'sd_attachments';
    protected $fillable = ['id', 'saved', 'owner', 'value', 'type', 'size', 'created_at', 'updated_at',

    ];
}
