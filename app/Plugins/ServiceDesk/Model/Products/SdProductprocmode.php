<?php
namespace App\Plugins\ServiceDesk\Model\Products;
use Illuminate\Database\Eloquent\Model;

class SdProductprocmode extends Model
{
    protected $table = 'sd_product_proc_mode';
    protected $fillable = ['id','name','created_at','updated_at'];
}