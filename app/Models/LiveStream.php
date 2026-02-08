<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LiveStream extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'stream_key',
        'platform',
        'stream_url',
        'embed_url',
        'scheduled_at',
        'started_at',
        'ended_at',
        'status',
        'viewer_count',
        'created_by',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'viewer_count' => 'integer',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeLive($query)
    {
        return $query->where('status', 'live');
    }

    public function scopeEnded($query)
    {
        return $query->where('status', 'ended');
    }

    public function getFormattedDurationAttribute(): string
    {
        if (!$this->started_at || !$this->ended_at) {
            return '--:--';
        }
        
        $duration = $this->ended_at->diffInSeconds($this->started_at);
        $hours = floor($duration / 3600);
        $minutes = floor(($duration % 3600) / 60);
        $seconds = $duration % 60;
        
        if ($hours > 0) {
            return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        }
        
        return sprintf('%02d:%02d', $minutes, $seconds);
    }

    public function getPlatformIconAttribute(): string
    {
        return match($this->platform) {
            'youtube' => 'fab fa-youtube',
            'facebook' => 'fab fa-facebook',
            'instagram' => 'fab fa-instagram',
            'custom' => 'fas fa-broadcast-tower',
            default => 'fas fa-video'
        };
    }
}
