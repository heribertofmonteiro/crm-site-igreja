<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyticsEvent extends Model
{
    protected $fillable = [
        'trackable_type',
        'trackable_id',
        'event_name',
        'event_data',
        'ip_address',
        'user_agent',
        'event_timestamp'
    ];

    protected $casts = [
        'event_data' => 'array',
        'event_timestamp' => 'datetime',
    ];

    public function trackable()
    {
        return $this->morphTo();
    }
}
