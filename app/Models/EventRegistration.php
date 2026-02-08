<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'name',
        'email',
        'phone',
        'notes',
        'status',
        'registered_at',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeWaitlist($query)
    {
        return $query->where('status', 'waitlist');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'confirmed' => '<span class="badge badge-success">Confirmado</span>',
            'cancelled' => '<span class="badge badge-danger">Cancelado</span>',
            'waitlist' => '<span class="badge badge-warning">Lista de Espera</span>',
            default => '<span class="badge badge-secondary">' . $this->status . '</span>'
        };
    }

    public function getFormattedRegisteredAtAttribute(): string
    {
        return $this->registered_at->format('d/m/Y H:i');
    }

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function isOnWaitlist(): bool
    {
        return $this->status === 'waitlist';
    }

    public function canConfirm(): bool
    {
        return $this->status !== 'confirmed';
    }

    public function canCancel(): bool
    {
        return $this->status === 'confirmed';
    }
}
