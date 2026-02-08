<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorshipRehearsal extends Model
{
    use HasFactory;

    protected $fillable = [
        'worship_team_id',
        'scheduled_at',
        'started_at',
        'ended_at',
        'location',
        'notes',
        'status',
        'created_by',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function worshipTeam(): BelongsTo
    {
        return $this->belongsTo(WorshipTeam::class);
    }

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

    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_at', '>', now())
                    ->where('status', 'scheduled')
                    ->orderBy('scheduled_at');
    }

    public function scopePast($query)
    {
        return $query->where('scheduled_at', '<', now())
                    ->orderBy('scheduled_at', 'desc');
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

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'scheduled' => '<span class="badge badge-warning">Agendado</span>',
            'in_progress' => '<span class="badge badge-info">Em Andamento</span>',
            'completed' => '<span class="badge badge-success">Concluído</span>',
            'cancelled' => '<span class="badge badge-danger">Cancelado</span>',
            default => '<span class="badge badge-secondary">' . $this->status . '</span>'
        };
    }

    public function canStart(): bool
    {
        return $this->status === 'scheduled' && $this->scheduled_at->isPast();
    }

    public function canComplete(): bool
    {
        return $this->status === 'in_progress';
    }

    public function canCancel(): bool
    {
        return in_array($this->status, ['scheduled', 'in_progress']);
    }
}
