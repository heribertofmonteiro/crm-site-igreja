<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'type',
        'priority',
        'department_id',
        'author_id',
        'is_active',
        'published_at',
        'expires_at',
        'views_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
        'views_count' => 'integer',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now());
    }

    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
        });
    }

    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', now());
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByPriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeVisible($query)
    {
        return $query->active()->published()->notExpired();
    }

    public function getTypeBadgeAttribute(): string
    {
        return match($this->type) {
            'general' => '<span class="badge badge-primary">Geral</span>',
            'urgent' => '<span class="badge badge-danger">Urgente</span>',
            'event' => '<span class="badge badge-info">Evento</span>',
            'meeting' => '<span class="badge badge-warning">Reunião</span>',
            default => '<span class="badge badge-secondary">' . $this->type . '</span>'
        };
    }

    public function getPriorityBadgeAttribute(): string
    {
        return match($this->priority) {
            'low' => '<span class="badge badge-secondary">Baixa</span>',
            'normal' => '<span class="badge badge-info">Normal</span>',
            'high' => '<span class="badge badge-warning">Alta</span>',
            'urgent' => '<span class="badge badge-danger">Urgente</span>',
            default => '<span class="badge badge-secondary">' . $this->priority . '</span>'
        };
    }

    public function getFormattedPublishedAtAttribute(): string
    {
        return $this->published_at->format('d/m/Y H:i');
    }

    public function getFormattedExpiresAtAttribute(): ?string
    {
        return $this->expires_at ? $this->expires_at->format('d/m/Y H:i') : null;
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isPublished(): bool
    {
        return $this->published_at && $this->published_at->isPast();
    }

    public function isVisible(): bool
    {
        return $this->is_active && $this->isPublished() && !$this->isExpired();
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function canBeEditedByUser(User $user): bool
    {
        return $user->hasRole('admin') || 
               $this->author_id === $user->id || 
               ($this->department_id && $user->department_id === $this->department_id);
    }
}
