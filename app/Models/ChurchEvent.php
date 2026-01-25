<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChurchEvent extends Model
{
    protected $fillable = [
        'title',
        'description',
        'event_date',
        'location',
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }
}
