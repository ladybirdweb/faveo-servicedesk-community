<?php

namespace App\Itil\Models\Problem;

use Illuminate\Database\Eloquent\Model;

class ProblemChangeRelation extends Model
{
    protected $table = 'sd_problem_change';
    protected $fillable = [
        'problem_id',
        'change_id',
    ];
}
