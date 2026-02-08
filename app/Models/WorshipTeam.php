<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorshipTeam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'leader_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function leader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function rehearsals(): HasMany
    {
        return $this->hasMany(WorshipRehearsal::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getUpcomingRehearsalsAttribute()
    {
        return $this->rehearsals()
            ->where('scheduled_at', '>', now())
            ->where('status', 'scheduled')
            ->orderBy('scheduled_at')
            ->get();
    }

    public function getRehearsalCountAttribute(): int
    {
        return $this->rehearsals()->count();
    }

    public function getCompletedRehearsalsCountAttribute(): int
    {
        return $this->rehearsals()->where('status', 'completed')->count();
    }

    public function getLastRehearsalAttribute(): ?WorshipRehearsal
    {
        return $this->rehearsals()
            ->where('status', 'completed')
            ->orderBy('scheduled_at', 'desc')
            ->first();
    }
}
