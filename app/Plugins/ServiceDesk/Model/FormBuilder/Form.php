<?php

namespace App\Plugins\ServiceDesk\Model\FormBuilder;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $table = 'sd_forms';
    protected $fillable = [
        'title',
    ];

    public function field()
    {
        return $this->hasMany('App\Plugins\ServiceDesk\Model\FormBuilder\FormField');
    }

    public function assetType()
    {
        return $this->hasMany('App\Plugins\ServiceDesk\Model\Assets\AssetFormRelation');
    }

    public function deleteFields()
    {
        $fields = $this->field()->get();
        if ($fields->count() > 0) {
            foreach ($fields as $field) {
                $field->delete();
            }
        }
    }

    public function delete()
    {
        $this->deleteFields();
        $this->assetType()->delete();
        parent::delete();
    }
}
