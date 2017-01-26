<?php
namespace App\Plugins\ServiceDesk\Model\Changes;
use Illuminate\Database\Eloquent\Model;

class SdChangepriorities extends Model
{
    protected $table = 'sd_change_priorities';
    protected $fillable = ['id','name','created_at','updated_at'];
}