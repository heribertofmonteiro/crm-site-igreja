<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialVolunteer extends Model
{
    protected $fillable = [
        'social_project_id',
        'user_id',
        'role',
        'joined_at',
        'status',
    ];

    protected $casts = [
        'joined_at' => 'date',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(SocialProject::class, 'social_project_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
