<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'event_type_id',
        'venue_id',
        'start_time',
        'end_time',
        'is_all_day',
        'image',
        'contact_info',
        'ticket_price',
        'max_participants',
        'current_participants',
        'status',
        'is_public',
        'requires_registration',
        'registration_deadline',
        'created_by',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_all_day' => 'boolean',
        'contact_info' => 'array',
        'ticket_price' => 'decimal:2',
        'max_participants' => 'integer',
        'current_participants' => 'integer',
        'is_public' => 'boolean',
        'requires_registration' => 'boolean',
        'registration_deadline' => 'datetime',
    ];

    public function eventType(): BelongsTo
    {
        return $this->belongsTo(EventType::class);
    }

    public function venue(): BelongsTo
    {
        return $this->belongsTo(EventVenue::class, 'venue_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function resources(): HasMany
    {
        return $this->hasMany(EventResource::class);
    }

    public function confirmedRegistrations(): HasMany
    {
        return $this->registrations()->where('status', 'confirmed');
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_time', '>', now())
                    ->where('status', 'planned');
    }

    public function scopePast($query)
    {
        return $query->where('end_time', '<', now())
                    ->orderBy('start_time', 'desc');
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeRequiresRegistration($query)
    {
        return $query->where('requires_registration', true);
    }

    public function getFormattedStartTimeAttribute(): string
    {
        return $this->start_time->format('d/m/Y H:i');
    }

    public function getFormattedEndTimeAttribute(): string
    {
        return $this->end_time->format('d/m/Y H:i');
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->start_time->format('d/m/Y');
    }

    public function getFormattedTimeAttribute(): string
    {
        if ($this->is_all_day) {
            return 'Dia todo';
        }
        
        return $this->start_time->format('H:i') . ' - ' . $this->end_time->format('H:i');
    }

    public function getDurationAttribute(): string
    {
        if ($this->is_all_day) {
            return 'Dia todo';
        }
        
        $duration = $this->end_time->diffInMinutes($this->start_time);
        $hours = floor($duration / 60);
        $minutes = $duration % 60;
        
        if ($hours > 0) {
            return $hours . 'h' . ($minutes > 0 ? $minutes . 'min' : '');
        }
        
        return $minutes . 'min';
    }

    public function getFormattedTicketPriceAttribute(): string
    {
        if ($this->ticket_price == 0) {
            return 'Gratuito';
        }
        
        return 'R$ ' . number_format($this->ticket_price, 2, ',', '.');
    }

    public function getAvailableSpotsAttribute(): int
    {
        if (!$this->max_participants) {
            return 999; // Unlimited
        }
        
        return max(0, $this->max_participants - $this->current_participants);
    }

    public function isFullyBooked(): bool
    {
        return $this->max_participants && $this->current_participants >= $this->max_participants;
    }

    public function canRegister(): bool
    {
        if (!$this->requires_registration) {
            return false;
        }
        
        if ($this->registration_deadline && $this->registration_deadline->isPast()) {
            return false;
        }
        
        if ($this->isFullyBooked()) {
            return false;
        }
        
        return true;
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'planned' => '<span class="badge badge-primary">Planejado</span>',
            'ongoing' => '<span class="badge badge-success">Em Andamento</span>',
            'completed' => '<span class="badge badge-info">Concluído</span>',
            'cancelled' => '<span class="badge badge-danger">Cancelado</span>',
            default => '<span class="badge badge-secondary">' . $this->status . '</span>'
        };
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }
        
        return asset('storage/' . $this->image);
    }

    protected static function booted()
    {
        static::creating(function ($event) {
            $event->slug = Str::slug($event->title);
        });
        
        static::updating(function ($event) {
            if ($event->isDirty('title')) {
                $event->slug = Str::slug($event->title);
            }
        });
    }
}
