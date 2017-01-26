<?php
namespace App\Plugins\ServiceDesk\Model\Common;
use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
{
    protected $table = 'sd_attachments';
    protected $fillable = ['saved','owner','value','type','size'];
}