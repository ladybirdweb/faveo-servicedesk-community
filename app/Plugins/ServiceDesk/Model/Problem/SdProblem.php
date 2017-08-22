<?php

namespace App\Plugins\ServiceDesk\Model\Problem;

use Illuminate\Database\Eloquent\Model;

class SdProblem extends Model
{
    protected $table = 'sd_problem';
    protected $fillable = ['id', 'from', 'name', 'subject', 'description', 'status_type_id', 'priority_id', 'impact_id', 'location_type_id', 'group_id', 'agent_id', 'assigned_id',
        'department',
    ];

    /**
     * get the requester/from.
     *
     * @return string
     */
    public function requesters()
    {
        $value = '--';
        $attr = $this->attributes['from'];
        if ($attr) {
            $users = new \App\User();
            $user = $users->where('email', $attr)->first();
            if ($user) {
                $value = "$user->first_name $user->last_name";
                if ($value == ' ') {
                    $value = $user->user_name;
                }
            }
        }

        return $value;
    }

    public function organization()
    {
        $value = '--';
        $attr = $this->attributes['from'];
        if ($attr) {
            $users = new \App\User();
            $user = $users->where('email', $attr)->first();
            if ($user) {
                $value = $user->getOrgWithLink();
            }
        }

        return $value;
    }

    /**
     * get the assets.
     *
     * @return type
     */
    public function assets()
    {
        $table = $this->table;
        $id = $this->attributes['id'];
        $owner = "$table:$id";
        $ids = [];
        $relations = new \App\Plugins\ServiceDesk\Model\Common\AssetRelation();
        $relation = $relations->where('owner', $owner)->first();
        if ($relation) {
            $ids = $relation->asset_ids;
        }

        return $ids;
    }

    public function getAssets()
    {
        $ids = $this->assets();
        $asset = new \App\Plugins\ServiceDesk\Model\Assets\SdAssets();
        $assets = '';
        if (count($ids) > 0) {
            foreach ($ids as $id) {
                $ass = $asset->find($id);
                if ($ass) {
                    $value = '<a href='.url('service-desk/assets/'.$id.'/show').'>'.ucfirst($ass->name).'</a>';
                    $assets .= $value.'</br>';
                }
            }
        }

        return $assets;
    }

    /**
     * get the status name.
     *
     * @return string
     */
    public function statuses()
    {
        $value = '--';
        $status = $this->attributes['status_type_id'];
        if ($status) {
            $statuses = $this->belongsTo('App\Model\helpdesk\Ticket\Ticket_Status', 'status_type_id')->first();
            if ($statuses) {
                $value = $statuses->name;
            }
        }

        return ucfirst($value);
    }

    /**
     * get the department name.
     *
     * @return string
     */
    public function departments()
    {
        $value = '--';
        $attr = $this->attributes['department'];
        if ($attr) {
            $attrs = $this->belongsTo('App\Model\helpdesk\Agent\Department', 'department')->first();
            if ($attrs) {
                $value = $attrs->name;
            }
        }

        return ucfirst($value);
    }

    /**
     * get the impact name.
     *
     * @return string
     */
    public function impacts()
    {
        $value = '--';
        $attr = $this->attributes['impact_id'];
        //dd()
        if ($attr) {
            $attrs = $this->belongsTo('App\Plugins\ServiceDesk\Model\Problem\Impact', 'impact_id')->first();
            if ($attrs) {
                $value = $attrs->name;
            }
        }

        return ucfirst($value);
    }

    /**
     * get the location name.
     *
     * @return string
     */
    public function locations()
    {
        $value = '--';
        $attr = $this->attributes['location_type_id'];
        if ($attr) {
            $attrs = $this->belongsTo('App\Plugins\ServiceDesk\Model\Problem\Location', 'location_type_id')->first();
            //dd($attrs);
            if ($attrs) {
                $value = '<a href='.url('service-desk/location-types/'.$attr.'/show').">$attrs->title</a>";
            }
        }

        return ucfirst($value);
    }

    /**
     * get the priority name.
     *
     * @return string
     */
    public function prioritys()
    {
        $value = '--';
        $attr = $this->attributes['priority_id'];
        //dd($attr);
        if ($attr) {
            $attrs = $this->belongsTo('App\Model\helpdesk\Ticket\Ticket_Priority', 'priority_id', 'priority_id')->first();
            if ($attrs) {
                $value = $attrs->priority;
            }
        }

        return ucfirst($value);
    }

    /**
     * get the group name.
     *
     * @return string
     */
    public function groups()
    {
        $value = '--';
        $attr = $this->attributes['group_id'];
        if ($attr) {
            $attrs = $this->belongsTo('App\Model\helpdesk\Agent\Groups', 'group_id')->first();
            if ($attrs) {
                $value = $attrs->name;
            }
        }

        return ucfirst($value);
    }

    /**
     * get the assigned agent/admin email.
     *
     * @return string
     */
    public function assigneds()
    {
        $value = '--';
        $attr = $this->attributes['assigned_id'];
        if ($attr) {
            $attrs = $this->belongsTo('App\User', 'assigned_id')->first();
            if ($attrs) {
                $value = $attrs->email;
            }
        }

        return ucfirst($value);
    }

    /**
     * get the description of this model.
     *
     * @return string
     */
    public function descriptions()
    {
        $value = '--';
        $attr = $this->attributes['description'];
        if ($attr) {
            $value = str_limit($attr, 10);
        }
        if (strlen($value) > 10) {
            $value .= "  <a href=# id='show-description'>Show</a>";
        }

        return ucfirst($value);
    }

    public function attachments()
    {
        $table = $this->table;
        $id = $this->attributes['id'];
        $owner = "$table:$id";
        $attachments = new \App\Plugins\ServiceDesk\Model\Common\Attachments();
        $attachment = $attachments->where('owner', $owner)->get();

        return $attachment;
    }

    /**
     * detach the problem fro relation table.
     */
    public function detachRelation()
    {
        $relation = new \App\Plugins\ServiceDesk\Model\Common\TicketRelation();
        $table = $this->table;
        $id = $this->attributes['id'];
        $owner = "$table:$id";
        $relations = $relation->where('owner', $owner)->get();
        if ($relations->count() > 0) {
            foreach ($relations as $rel) {
                if ($rel) {
                    $rel->delete();
                }
            }
        }
    }

    public function changeRelaion()
    {
        $through = "App\Plugins\ServiceDesk\Model\Problem\ProblemChangeRelation";
        $firstKey = 'problem_id';

        return $this->hasMany($through, $firstKey);
    }

    public function change()
    {
        $relation = $this->changeRelaion()->first();
        if ($relation) {
            $changeid = $relation->change_id;
            $changes = new \App\Plugins\ServiceDesk\Model\Changes\SdChanges();
            $change = $changes->find($changeid);

            return $change;
        }
    }

    /**
     * delete the attachment.
     *
     * @param int $id
     */
    public function deleteAttachment($id)
    {
        $table = $this->table;
        \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::deleteAttachments($id, $table);
    }

    public function delete()
    {
        $id = $this->id;
        $this->deleteAttachment($id);
        $this->detachRelation();
        $this->changeRelaion()->delete();
        parent::delete();
    }

    //    public function general(){
    //        $general = new \App\Plugins\ServiceDesk\Model\Common\GeneralInfo();
    //        $table = $this->table;
    //        $id  = $this->attributes['id'];
    //        $owner = "$table:$id";
    //        $generals = $general->where('owner',$owner)->lists('value','key')->toArray();
    //        return $generals;
    //    }

    public function generalAttachments($identifier)
    {
        $table = $this->table;
        $id = $this->attributes['id'];
        //$identifier = "root-cause";
        $owner = "$table:$identifier:$id";
        $attachment = new \App\Plugins\ServiceDesk\Model\Common\Attachments();
        $attachments = $attachment->where('owner', $owner)->get();

        return $attachments;
    }

    public function getGeneralByIdentifier($identifier)
    {
        $table = $this->table;
        $id = $this->attributes['id'];
        $owner = "$table:$id";
        $generals = new \App\Plugins\ServiceDesk\Model\Common\GeneralInfo();
        $general = $generals->where('owner', $owner)->where('key', $identifier)->first();

        return $general;
    }

    public function table()
    {
        return $this->table;
    }

    public function tickets()
    {
        $ticket = $this->ticketRelation();
        $join = $ticket->join('ticket_thread', 'tickets.id', '=', 'ticket_thread.ticket_id')
                ->select('tickets.id', 'tickets.ticket_number', 'ticket_thread.title')
                ->whereNotNull('ticket_thread.title')
                ->groupBy('tickets.id')
                ->get();

        return $join;
    }

    public function ticketRelation()
    {
        $problemid = $this->attributes['id'];
        $table = $this->table;
        $owner = "$table:$problemid";
        $ticket_relation = new \App\Plugins\ServiceDesk\Model\Common\TicketRelation();
        $relation = $ticket_relation->where('owner', $owner)->lists('ticket_id')->toArray();
        $ticket = new \App\Plugins\ServiceDesk\Model\Common\Ticket();
        $tickets = $ticket->whereIn('tickets.id', $relation);

        return $tickets;
    }

    public function subject()
    {
        $id = $this->attributes['id'];
        $title = $this->attributes['subject'];
        $subject = '<a href='.url('service-desk/problem/'.$id.'/show').'>'.$title.'</a>';

        return $subject;
    }
}
