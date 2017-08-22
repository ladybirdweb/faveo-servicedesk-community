<?php

namespace App\Plugins\ServiceDesk\Model\Vendor;

use Illuminate\Database\Eloquent\Model;

class SdVendors extends Model
{
    protected $table = 'sd_vendors';
    protected $fillable = ['id', 'name', 'primarycontact', 'email', 'description', 'address', 'status', 'created_at', 'updated_at',

    ];

    public function statuses()
    {
        $value = 'Inactive';
        $status = $this->attributes['status'];
        if ($status == 1) {
            $value = 'Active';
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
}
