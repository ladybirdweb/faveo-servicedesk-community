<?php

namespace App\Itil\Models\Common;

use Illuminate\Database\Eloquent\Model;

class CabVote extends Model
{
    protected $table = 'sd_cab_votes';
    protected $fillable = [
        'cab_id',
        'user_id',
        'comment',
        'vote',
        'owner',
    ];
}
