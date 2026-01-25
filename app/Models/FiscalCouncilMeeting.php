<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FiscalCouncilMeeting extends Model
{
    protected $fillable = [
        'meeting_date',
        'attendees',
        'minutes',
        'decisions',
        'status',
    ];

    protected $casts = [
        'meeting_date' => 'date',
        'attendees' => 'array',
    ];
}
