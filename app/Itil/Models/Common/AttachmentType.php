<?php

namespace App\Itil\Models\Common;

use Illuminate\Database\Eloquent\Model;

class AttachmentType extends Model
{
    protected $table = 'sd_attachment_types';
    protected $fillable = ['name'];
}
