<?php

namespace App\Plugins\ServiceDesk\Model\Common;

use App\Model\helpdesk\Ticket\Tickets;

class Ticket extends Tickets
{
    public function ticketRelation()
    {
        return $this->hasMany("App\Plugins\ServiceDesk\Model\Common\TicketRelation", 'ticket_id');
    }

    public function getTicketRelation($table)
    {
        //dd($table);
        $relation = $this->ticketRelation()->where('owner', 'LIKE', $table.'%')->first();
        if ($relation) {
            $owner = $relation->owner;
            $explode = explode(':', $owner);
            $shcema = array_first($explode);
            $id = array_last($explode);
            $model = $this->switchCase($shcema, $id);
            if ($model) {
                return $model;
            }
        }
    }

    public function switchCase($table, $id)
    {
        $problem = new \App\Plugins\ServiceDesk\Model\Problem\SdProblem();
        $asset = new \App\Plugins\ServiceDesk\Model\Assets\SdAssets();
        $change = new \App\Plugins\ServiceDesk\Model\Changes\SdChanges();
        switch ($table) {
            case 'sd_problem':
                return $problem->find($id);
            case 'sd_assets':
                return $asset->find($id);
            case 'sd_changes':
                return $change->find($id);
        }
    }

    public function table()
    {
        return $this->table;
    }

    public function statuses()
    {
        $name = '--';
        $status = $this->statusRelation()->first();
        if ($status) {
            $name = $status->name;
        }

        return $name;
    }

    public function statusRelation()
    {
        $related = "App\Model\helpdesk\Ticket\Ticket_Status";

        return $this->belongsTo($related, 'status');
    }

    public function subject()
    {
        $subject = '';
        $thread = $this->thread()->whereNotNull('title')->first();
        $id = $this->attributes['id'];
        if ($thread) {
            $title = $thread->title;
            $subject = '<a href='.url('thread/'.$id).'>'.$title.'</a>';
        }

        return $subject;
    }
}
