<?php

namespace App\Itil\Models\Common;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'sd_locations';
    protected $fillable = ['id', 'name', 'created_at', 'updated_at',

    ];

    public function departmentRelation()
    {
        return $this->belongsTo('App\Model\helpdesk\Agent\Department', 'departments');
    }

    /**
     * get the department name.
     *
     * @return string
     */
    public function departments()
    {
        $value = '--';
        $attr = $this->attributes['departments'];
        if ($attr) {
            $attrs = $this->departmentRelation()->first();
            if ($attrs) {
                $value = $attrs->name;
            }
        }

        return ucfirst($value);
    }

    public function category()
    {
        return $this->belongsTo('App\Itil\Models\Changes\SdLocationcategories', 'location_category_id');
    }

    public function locationCategory()
    {
        $value = '--';
        $attr = $this->attributes['location_category_id'];
        if ($attr) {
            $attrs = $this->category()->first();
            if ($attrs) {
                $value = $attrs->name;
            }
        }

        return ucfirst($value);
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
