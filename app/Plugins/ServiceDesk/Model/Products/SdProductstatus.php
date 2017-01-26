<?php
namespace App\Plugins\ServiceDesk\Model\Products;
use Illuminate\Database\Eloquent\Model;

class SdProductstatus extends Model
{
    protected $table = 'sd_product_status';
    protected $fillable = ['id','name','created_at','updated_at'];
}