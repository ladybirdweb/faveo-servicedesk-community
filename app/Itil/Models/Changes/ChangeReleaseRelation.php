<?php

namespace App\Itil\Models\Changes;

use Illuminate\Database\Eloquent\Model;

class ChangeReleaseRelation extends Model
{
    protected $table = 'sd_change_release';
    protected $fillable = [
        'change_id',
        'release_id',
        ];
}
