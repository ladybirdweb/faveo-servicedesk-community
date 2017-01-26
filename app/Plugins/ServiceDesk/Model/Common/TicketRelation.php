<?php
namespace App\Plugins\ServiceDesk\Model\Common;
use Illuminate\Database\Eloquent\Model;

class TicketRelation extends Model
{
    protected $table = 'sd_ticket_relation';
    protected $fillable = ['ticket_id','owner'];
    
}