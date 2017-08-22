<?php

namespace App\Plugins\ServiceDesk\Model\Changes;

use Illuminate\Database\Eloquent\Model;

class SdChanges extends Model
{
    protected $table = 'sd_changes';
    protected $fillable = [
        'id',
        'requester',
        'description',
        'subject',
        'status_id',
        'priority_id',
        'change_type_id',
        'impact_id',
        'location_id',
        'approval_id',
        ];

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

    /**
     * get the requester/from.
     *
     * @return string
     */
    public function requesters()
    {
        $value = '--';
        $attr = $this->attributes['requester'];
        if ($attr) {
            $users = new \App\User();
            $user = $users->where('id', $attr)->first();
            if ($user) {
                $value = "$user->first_name $user->last_name";
                if ($value == ' ') {
                    $value = $user->user_name;
                }
            }
        }

        return $value;
    }

    public function cab()
    {
        return $this->belongsTo('App\Plugins\ServiceDesk\Model\Cab\Cab', 'approval_id');
    }

    public function approvers()
    {
        $value = '--';
        $attr = $this->attributes['approval_id'];
        $id = $this->attributes['id'];
        $table = $this->table;
        $owner = "$table:$id";
        if ($attr) {
            $attrs = $this->cab()->first();
            if ($attrs) {
                $value = "<a href='".url('service-desk/cabs/'.$attr.'/'.$owner.'/show')."'>$attrs->name</a>";
            }
        }
        //dd($value);
        return ucfirst($value);
    }

    public function deleteAttachment($id)
    {
        $table = $this->table;
        \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::deleteAttachments($id, $table);
    }

    public function detachRelation($id)
    {
        $table = $this->table;
        $owner = "$table:$id";
        $relations = new \App\Plugins\ServiceDesk\Model\Common\AssetRelation();
        $relation = $relations->where('owner', $owner)->first();
        if ($relation) {
            $relation->delete();
        }
    }

    public function delete()
    {
        $id = $this->id;
        $this->deleteAttachment($id);
        $this->detachRelation($id);
        $this->releaseRelaion()->first()->delete();
        parent::delete();
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

    public function locationRelation()
    {
        return $this->belongsTo('App\Plugins\ServiceDesk\Model\Releases\SdLocations', 'location_id');
    }

    /**
     * get the location name.
     *
     * @return string
     */
    public function locations()
    {
        $value = '--';
        $attr = $this->attributes['location_id'];
        if ($attr) {
            $attrs = $this->locationRelation()->first();
            if ($attrs) {
                $value = '<a href='.url('service-desk/location-types/'.$attr.'/show').">$attrs->title</a>";
            }
        }

        return ucfirst($value);
    }

    public function status()
    {
        return $this->belongsTo('App\Plugins\ServiceDesk\Model\Changes\SdChangestatus', 'status_id');
    }

    /**
     * get the status name.
     *
     * @return string
     */
    public function statuses()
    {
        $value = '--';
        $status = $this->attributes['status_id'];
        if ($status) {
            $statuses = $this->status()->first();
            if ($statuses) {
                $value = $statuses->name;
            }
        }

        return ucfirst($value);
    }

    public function priority()
    {
        return $this->belongsTo('App\Plugins\ServiceDesk\Model\Changes\SdChangepriorities', 'priority_id');
    }

    /**
     * get the priority name.
     *
     * @return string
     */
    public function priorities()
    {
        $value = '--';
        $attr = $this->attributes['priority_id'];
        if ($attr) {
            $attrs = $this->priority()->first();
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
            $attrs = $this->belongsTo('App\Plugins\ServiceDesk\Model\Changes\SdImpacttypes', 'impact_id')->first();
            if ($attrs) {
                $value = $attrs->name;
            }
        }

        return ucfirst($value);
    }

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

    public function changeType()
    {
        return $this->belongsTo('App\Plugins\ServiceDesk\Model\Changes\SdChangetypes', 'change_type_id');
    }

    public function changeTypes()
    {
        $value = '--';
        $attr = $this->attributes['change_type_id'];
        if ($attr) {
            $attrs = $this->changeType()->first();
            if ($attrs) {
                $value = $attrs->name;
            }
        }

        return ucfirst($value);
    }

    public function releaseRelaion()
    {
        $through = "App\Plugins\ServiceDesk\Model\Changes\ChangeReleaseRelation";
        $firstKey = 'change_id';

        return $this->hasMany($through, $firstKey);
    }

    public function release()
    {
        $relation = $this->releaseRelaion()->first();
        if ($relation) {
            $releaseid = $relation->release_id;
            $releases = new \App\Plugins\ServiceDesk\Model\Releases\SdReleases();
            $release = $releases->find($releaseid);

            return $release;
        }
    }

    public function tickets()
    {
        return new \Illuminate\Support\Collection();
    }

    public function table()
    {
        return $this->table;
    }

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

    public function subject()
    {
        $id = $this->attributes['id'];
        $title = $this->attributes['subject'];
        $subject = '<a href='.url('service-desk/changes/'.$id.'/show').'>'.$title.'</a>';

        return $subject;
    }
}
