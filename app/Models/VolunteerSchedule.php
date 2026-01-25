<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerSchedule extends Model
{
    protected $fillable = ['volunteer_role_id', 'user_id', 'event_date', 'start_time', 'end_time', 'status', 'notes'];

    public function volunteerRole()
    {
        return $this->belongsTo(VolunteerRole::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
