<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadershipTraining extends Model
{
    protected $fillable = [
        'name',
        'description',
        'trainer',
        'participants',
        'training_date',
        'duration_hours',
        'status',
    ];

    protected $casts = [
        'participants' => 'array',
        'training_date' => 'date',
    ];
}
