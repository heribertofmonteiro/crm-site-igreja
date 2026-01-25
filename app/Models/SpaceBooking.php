<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpaceBooking extends Model
{
    protected $fillable = [
        'space_name',
        'booked_by',
        'start_time',
        'end_time',
        'purpose',
        'status',
        'notes',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'booked_by');
    }
}
