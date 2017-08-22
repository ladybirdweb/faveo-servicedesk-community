<?php

namespace App\Plugins\ServiceDesk\Model\Assets;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'department';
    protected $fillable = ['id', 'name', 'type', 'sla', 'manager', 'ticket_assignment', 'outgoing_email', 'template_set', 'auto_ticket_response',
    'auto_message_response', 'auto_response_email', 'recipient', 'group_access', 'department_sign', 'created_at', 'updated_at', ];
}
