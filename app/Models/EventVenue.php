<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventVenue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'address',
        'city',
        'state',
        'postal_code',
        'capacity',
        'latitude',
        'longitude',
        'facilities',
        'is_active',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'facilities' => 'array',
        'is_active' => 'boolean',
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'venue_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->address,
            $this->city,
            $this->state,
            $this->postal_code
        ]);

        return implode(', ', $parts);
    }

    public function getFormattedCapacityAttribute(): string
    {
        return $this->capacity ? number_format($this->capacity, 0, '.', '.') . ' pessoas' : '--';
    }

    public function hasFacility(string $facility): bool
    {
        return in_array($facility, $this->facilities ?? []);
    }

    public function getFacilitiesListAttribute(): string
    {
        if (empty($this->facilities)) {
            return '--';
        }

        $facilityNames = [
            'parking' => 'Estacionamento',
            'wifi' => 'Wi-Fi',
            'projector' => 'Projetor',
            'sound_system' => 'Sistema de Som',
            'air_conditioning' => 'Ar Condicionado',
            'accessibility' => 'Acessibilidade',
            'kitchen' => 'Cozinha',
            'restrooms' => 'Banheiros',
        ];

        $list = [];
        foreach ($this->facilities as $facility) {
            $list[] = $facilityNames[$facility] ?? $facility;
        }

        return implode(', ', $list);
    }

    public function getEventCountAttribute(): int
    {
        return $this->events()->count();
    }
}
