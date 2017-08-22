<?php

namespace App\Plugins\ServiceDesk\Model\Releases;

use Illuminate\Database\Eloquent\Model;

class SdReleases extends Model
{
    protected $table = 'sd_releases';
    protected $fillable = [
        'id',
        'description',
        'subject',
        'planned_start_date',
        'planned_end_date',
        'status_id',
        'priority_id',
        'release_type_id',
        'location_id',
        ];

    public function getPlannedStartDateAttribute($value)
    {
        //dd($value);
        if ($value == '0000-00-00 00:00:00' || $value == null) {
            $value = '--';
        }

        return $value;
    }

    public function getPlannedEndDateAttribute($value)
    {
        //dd($value);
        if ($value == '0000-00-00 00:00:00' || $value == null) {
            $value = '--';
        }

        return $value;
    }

    public function locationRelation()
    {
        return $this->belongsTo('App\Plugins\ServiceDesk\Model\Assets\SdLocations', 'location_id');
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
        return $this->belongsTo('App\Plugins\ServiceDesk\Model\Releases\SdReleasestatus', 'status_id');
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
        return $this->belongsTo('App\Plugins\ServiceDesk\Model\Releases\SdReleasepriorities', 'priority_id');
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

    public function releaseType()
    {
        return $this->belongsTo('App\Plugins\ServiceDesk\Model\Releases\SdReleasetypes', 'release_type_id');
    }

    public function releaseTypes()
    {
        $value = '--';
        $attr = $this->attributes['release_type_id'];
        if ($attr) {
            $attrs = $this->releaseType()->first();
            if ($attrs) {
                $value = $attrs->name;
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
        parent::delete();
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
        $subject = '<a href='.url('service-desk/releases/'.$id.'/show').'>'.$title.'</a>';

        return $subject;
    }
}
