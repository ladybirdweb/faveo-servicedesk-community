<?php

namespace App\Plugins\ServiceDesk\Model\Products;

use Illuminate\Database\Eloquent\Model;

class SdProducts extends Model
{
    protected $table = 'sd_products';
    protected $fillable = [
        'id',
        'name',
        'description',
        'manufacturer',
        'product_status_id',
        'product_mode_procurement_id',
        'all_department',
        'status',
    ];

    public function departmentRelation()
    {
        return $this->belongsTo('App\Model\helpdesk\Agent\Department', 'all_department');
    }

    /**
     * get the department name.
     *
     * @return string
     */
    public function departments()
    {
        $value = '--';
        $attr = $this->attributes['all_department'];
        if ($attr) {
            $attrs = $this->departmentRelation()->first();
            if ($attrs) {
                $value = $attrs->name;
            }
        }

        return ucfirst($value);
    }

    public function status()
    {
        return $this->belongsTo('App\Plugins\ServiceDesk\Model\Products\SdProductstatus', 'product_status_id');
    }

    /**
     * get the status name.
     *
     * @return string
     */
    public function productStatuses()
    {
        $value = '--';
        $status = $this->attributes['product_status_id'];
        if ($status) {
            $statuses = $this->status()->first();
            if ($statuses) {
                $value = $statuses->name;
            }
        }

        return ucfirst($value);
    }

    public function procurement()
    {
        return $this->belongsTo('App\Plugins\ServiceDesk\Model\Products\SdProductprocmode', 'product_mode_procurement_id');
    }

    /**
     * get the status name.
     *
     * @return string
     */
    public function procurements()
    {
        $value = '--';
        $status = $this->attributes['product_mode_procurement_id'];
        if ($status) {
            $statuses = $this->procurement()->first();
            if ($statuses) {
                $value = $statuses->name;
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

    public function statuses()
    {
        $value = '--';
        $attr = $this->attributes['status'];
        if ($attr == 1) {
            $value = 'Enabled';
        } else {
            $value = 'Disabled';
        }

        return $value;
    }

    public function vendorRelation()
    {
        return  $this->hasMany("App\Plugins\ServiceDesk\Model\Common\ProductVendorRelation", 'product_id');
    }

    public function vendors()
    {
        $vendorids = $this->vendorRelation()->lists('vendor_id')->toArray();
        $vendor = new \App\Plugins\ServiceDesk\Model\Vendor\SdVendors();
        $vendors = $vendor->whereIn('id', $vendorids)->get();

        return $vendors;
    }

    public function assetRelation()
    {
        return $this->hasMany('App\Plugins\ServiceDesk\Model\Assets\SdAssets', 'product_id');
    }

    public function assets()
    {
        $relation = $this->assetRelation();
        $assets = $relation->get();

        return $assets;
    }

    public function deleteProductInAsset()
    {
        $asset = $this->assetRelation()->first();
        if ($asset) {
            $asset->product_id = null;
            $asset->save();
        }
    }

    public function contractRelation()
    {
        return $this->hasMany('App\Plugins\ServiceDesk\Model\Contract\SdContract', 'product_id');
    }

    public function deleteProductInContract()
    {
        $contract = $this->contractRelation()->first();
        if ($contract) {
            $contract->product_id = null;
            $contract->save();
        }
    }

    public function deleteVendorRelation()
    {
        $relation = $this->vendorRelation()->first();
        if ($relation) {
            $relation->delete();
        }
    }

    public function delete()
    {
        $this->deleteProductInAsset();
        $this->deleteProductInContract();
        $this->deleteVendorRelation();
        parent::delete();
    }
}
