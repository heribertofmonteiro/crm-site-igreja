<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LgpdConsent extends Model
{
    protected $fillable = [
        'member_id',
        'consent_type',
        'consent_given',
        'consent_date',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'consent_given' => 'boolean',
        'consent_date' => 'datetime',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
