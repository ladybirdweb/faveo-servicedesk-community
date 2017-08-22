<?php

namespace App\Plugins\ServiceDesk\Model\Assets;

use App\Plugins\ServiceDesk\Model\Common\AssetRelation;
use Illuminate\Database\Eloquent\Model;

class SdAssets extends Model
{
    protected $table = 'sd_assets';
    protected $fillable = [
        'id',
        'name',
        'description',
        'department_id',
        'asset_type_id',
        'impact_type_id',
        'managed_by',
        'used_by',
        'attachment',
        'location_id',
        'assigned_on',
        'product_id',
        'external_id',
        'organization',
    ];

    public function setExternalIdAttribute($value)
    {
        $this->attributes['external_id'] = str_slug($value);
    }

    public function departmentRelation()
    {
        return $this->belongsTo('App\Model\helpdesk\Agent\Department', 'department_id');
    }

    /**
     * get the department name.
     *
     * @return string
     */
    public function departments()
    {
        $value = '--';
        $attr = $this->attributes['department_id'];
        if ($attr) {
            $attrs = $this->departmentRelation()->first();
            if ($attrs) {
                $value = $attrs->name;
            }
        }

        return ucfirst($value);
    }

    public function impactRelation()
    {
        return $this->belongsTo('App\Plugins\ServiceDesk\Model\Assets\SdImpactypes', 'impact_type_id');
    }

    /**
     * get the impact name.
     *
     * @return string
     */
    public function impacts()
    {
        $value = '--';
        $attr = $this->attributes['impact_type_id'];
        //dd()
        if ($attr) {
            $attrs = $this->impactRelation()->first();
            if ($attrs) {
                $value = $attrs->name;
            }
        }

        return ucfirst($value);
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

    public function assetTypes()
    {
        $value = '--';
        $attr = $this->attributes['asset_type_id'];
        if ($attr) {
            $attrs = $this->assetType()->first();
            if ($attrs) {
                $value = $attrs->name;
            }
        }

        return ucfirst($value);
    }

    public function used()
    {
        $value = '--';
        $attr = $this->attributes['used_by'];
        if ($attr) {
            $attrs = $this->usedBy()->first();
            if ($attrs) {
                $value = ucfirst($attrs->first_name).' '.ucfirst($attrs->last_name);
                if ($value == ' ') {
                    $value = $attrs->user_name;
                }
            }
        }

        return $value;
    }

    public function managed()
    {
        $value = '--';
        $attr = $this->attributes['managed_by'];
        if ($attr) {
            $attrs = $this->managedBy()->first();
            if ($attrs) {
                $value = ucfirst($attrs->first_name).' '.ucfirst($attrs->last_name);
                if ($value == ' ') {
                    $value = $attrs->user_name;
                }
            }
        }

        return $value;
    }

    public function products()
    {
        $value = '--';
        $attr = $this->attributes['product_id'];
        if ($attr) {
            $attrs = $this->product()->first();
            if ($attrs) {
                $value = '<a href='.url('service-desk/products/'.$attr.'/show').">$attrs->name</a>";
            }
        }

        return $value;
    }

    public function assignedOn()
    {
        $value = '--';
        $attr = $this->attributes['assigned_on'];
        if ($attr !== null) {
            $value = $this->attributes['assigned_on'];
        }

        return $value;
    }

    public function usedBy()
    {
        return $this->belongsTo('App\User', 'used_by');
    }

    public function managedBy()
    {
        return $this->belongsTo('App\User', 'managed_by');
    }

    public function assetType()
    {
        return $this->belongsTo('App\Plugins\ServiceDesk\Model\Assets\SdAssettypes');
    }

    public function relation()
    {
        return $this->hasMany('App\Plugins\ServiceDesk\Model\Common\TicketAssetProblem', 'asset_id');
    }

    public function assetForm()
    {
        return $this->hasMany('App\Plugins\ServiceDesk\Model\Assets\AssetForm', 'asset_id');
    }

    public function additionalData()
    {
        return $this->assetForm()->lists('value', 'key')->toArray();
    }

    public function product()
    {
        return $this->belongsTo('App\Plugins\ServiceDesk\Model\Products\SdProducts', 'product_id');
    }

    public function detachRelation()
    {
        $relations = $this->relation()->get();
        if ($relations->count() > 0) {
            foreach ($relations as $relation) {
                $relation->asset_id = null;
                $relation->save();
            }
        }
        $forms = $this->assetForm()->get();
        if ($forms->count() > 0) {
            foreach ($forms as $form) {
                $form->delete();
            }
        }
    }

    public function deleteAttachment($id)
    {
        \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::deleteAssetRelation($id);
        $table = $this->table;
        \App\Plugins\ServiceDesk\Controllers\Library\UtilityController::deleteAttachments($id, $table);
    }

    public function delete()
    {
        $id = $this->id;
        $this->deleteAttachment($id);
        $this->detachRelation();
        parent::delete();
    }

    public function requests()
    {
        $assets = $this->assetRelation();
        $ids = [];
        foreach ($assets as $key => $value) {
            $explode = explode('.', $key);
            $ids[] = array_first($explode);
        }

        return $this->getRequesters($ids);
    }

    public function assetRelation()
    {
        $relation = new AssetRelation();
        $relations = $relation->lists('asset_ids', 'id')->toArray();
        $array = array_dot($relations);
        $id = $this->attributes['id'];
        $array1 = array_where($array, function ($key, $value) use ($id) {
            if ($value == $id) {
                return $value;
            }
        });

        return $array1;
    }

    public function getRequesters($ids)
    {
        $relation = new AssetRelation();
        $relations = $relation->whereIn('id', $ids)->lists('owner')->toArray();
        $schema = [];
        if (count($relations) > 0) {
            foreach ($relations as $relation) {
                $explode = explode(':', $relation);
                $table = array_first($explode);
                $id = array_last($explode);
                //dd($id);
                $schema[] = $this->switchCase($table, $id);
            }
        }

        return $schema;
    }

    public function switchCase($table, $id)
    {
        $change = new \App\Plugins\ServiceDesk\Model\Changes\SdChanges();
        $release = new \App\Plugins\ServiceDesk\Model\Releases\SdReleases();
        $ticket = new \App\Plugins\ServiceDesk\Model\Common\Ticket();
        $problem = new \App\Plugins\ServiceDesk\Model\Problem\SdProblem();
        switch ($table) {
            case 'sd_changes':
                return $change->find($id);
            case 'sd_releases':
                return $release->find($id);
            case 'tickets':
                return $ticket->find($id);
            case 'sd_problem':
                return $problem->find($id);
        }
    }

    public function getOrganizationRelation()
    {
        $related = "App\Model\helpdesk\Agent_panel\Organization";

        return $this->belongsTo($related, 'organization');
    }

    public function getOrganization()
    {
        $name = '';
        if ($this->getOrganizationRelation()) {
            $org = $this->getOrganizationRelation()->first();
            if ($org) {
                $name = $org->name;
            }
        }

        return $name;
    }

    public function getOrgWithLink()
    {
        $name = '--';
        $org = $this->getOrganization();
        if ($org !== '') {
            $orgs = $this->getOrganizationRelation()->first();
            if ($orgs) {
                $id = $orgs->id;
                $name = '<a href='.url('organizations/'.$id).'>'.ucfirst($org).'</a>';
            }
        }

        return $name;
    }
}
