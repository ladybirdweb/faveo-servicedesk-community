<?php

namespace App\Itil\Models\Changes;

use Illuminate\Database\Eloquent\Model;

class SdLocationcategories extends Model
{
    protected $table = 'sd_location_categories';
    protected $fillable = ['id', 'name', 'parent_id', 'created_at', 'updated_at'];

    public function locations()
    {
        $related = 'App\Itil\Models\Common\Location';

        return $this->hasMany($related, 'location_category_id');
    }

    public function categoryDeleteFromLocation()
    {
        $locations = $this->locations()->get();
        //dd($locations);
        if ($locations->count() > 0) {
            foreach ($locations as $location) {
                $location->location_category_id = null;
                $location->save();
            }
        }
    }

    public function delete()
    {
        $this->categoryDeleteFromLocation();
        parent::delete();
    }
}
