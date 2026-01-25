<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerRole extends Model
{
    protected $fillable = ['name', 'description'];

    public function schedules()
    {
        return $this->hasMany(VolunteerSchedule::class);
    }
}
