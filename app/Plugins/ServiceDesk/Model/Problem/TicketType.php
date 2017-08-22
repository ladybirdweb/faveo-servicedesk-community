<?php

namespace App\Plugins\ServiceDesk\Model\Problem;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    protected $table = 'ticket_status';
    protected $fillable = ['id', 'name', 'created_at', 'updated_at',

    ];
}
