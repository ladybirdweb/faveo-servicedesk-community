<?php

namespace App\Plugins\ServiceDesk\Model\Contract;

use Illuminate\Database\Eloquent\Model;

class SdContract extends Model
{
    protected $table = 'sd_contracts';
    protected $fillable = [
        'id',
        'name',
        'description',
        'cost',
        'contract_type_id',
        'approver_id',
        'vendor_id',
        'license_type_id',
        'license_count',
        'attachment',
        'product_id',
        'notify_expiry',
        'contract_start_date',
        'contract_end_date',
    ];

    public function getNotifyExpiryAttribute($value)
    {
        if ($value == '0000-00-00 00:00:00' || $value = null) {
            $value = '--';
        }

        return $value;
    }

    public function getContractStartDateAttribute($value)
    {
        if ($value == '0000-00-00 00:00:00' || $value = null) {
            $value = '--';
        }

        return $value;
    }

    public function getContractEndDateAttribute($value)
    {
        if ($value == '0000-00-00 00:00:00' || $value = null) {
            $value = '--';
        }

        return $value;
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

    public function contractType()
    {
        return $this->belongsTo('App\Plugins\ServiceDesk\Model\Contract\ContractType', 'contract_type_id');
    }

    public function contractTypes()
    {
        $value = '--';
        $attr = $this->attributes['contract_type_id'];
        if ($attr) {
            $attrs = $this->contractType()->first();
            if ($attrs) {
                $value = $attrs->name;
            }
        }

        return ucfirst($value);
    }

    public function cab()
    {
        return $this->belongsTo('App\Plugins\ServiceDesk\Model\Cab\Cab', 'approver_id');
    }

    public function approvers()
    {
        $value = '--';
        $attr = $this->attributes['approver_id'];
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

    public function vendor()
    {
        return $this->belongsTo('App\Plugins\ServiceDesk\Model\Vendor\SdVendors', 'vendor_id');
    }

    public function vendors()
    {
        $value = '--';
        $attr = $this->attributes['vendor_id'];
        if ($attr) {
            $attrs = $this->vendor()->first();
            if ($attrs) {
                $value = "<a href='".url('service-desk/vendor/'.$attr.'/show')."'>$attrs->name</a>";
            }
        }
        //dd($value);
        return ucfirst($value);
    }

    public function licence()
    {
        return $this->belongsTo('App\Plugins\ServiceDesk\Model\Contract\License', 'license_type_id');
    }

    public function licenseTypes()
    {
        $value = '--';
        $attr = $this->attributes['license_type_id'];
        if ($attr) {
            $attrs = $this->licence()->first();
            if ($attrs) {
                $value = $attrs->name;
            }
        }
        //dd($value);
        return ucfirst($value);
    }

    public function product()
    {
        return $this->belongsTo('App\Plugins\ServiceDesk\Model\Products\SdProducts', 'product_id');
    }

    public function products()
    {
        $value = '--';
        $attr = $this->attributes['product_id'];
        if ($attr) {
            $attrs = $this->product()->first();
            if ($attrs) {
                $value = "<a href='".url('service-desk/products/'.$attr.'/show')."'>$attrs->name</a>";
            }
        }
        //dd($value);
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
}
