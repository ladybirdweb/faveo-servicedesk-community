<?php
namespace App\Plugins\ServiceDesk\Model\Common;
use Illuminate\Database\Eloquent\Model;

class AssetRelation extends Model
{
    protected $table = 'sd_asset_relations';
    protected $fillable = ['asset_ids','owner'];
    
    public function getAssetIdsAttribute($value){
        if($value){
            $value =  explode(',', $value);
        }
        return $value;
    }
}