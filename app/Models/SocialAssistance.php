<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialAssistance extends Model
{
    protected $fillable = [
        'social_project_id',
        'beneficiary_name',
        'beneficiary_contact',
        'assistance_type',
        'description',
        'date_provided',
        'amount',
    ];

    protected $casts = [
        'date_provided' => 'date',
        'amount' => 'decimal:2',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(SocialProject::class, 'social_project_id');
    }
}
