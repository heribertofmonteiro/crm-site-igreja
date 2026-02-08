<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiRateLimit extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'identifier',
        'max_attempts',
        'decay_minutes',
        'attempts',
        'reset_at',
    ];

    protected $casts = [
        'max_attempts' => 'integer',
        'decay_minutes' => 'integer',
        'attempts' => 'integer',
        'reset_at' => 'datetime',
    ];

    public function scopeByKey($query, string $key)
    {
        return $query->where('key', $key);
    }

    public function scopeByIdentifier($query, string $identifier)
    {
        return $query->where('identifier', $identifier);
    }

    public function scopeByAttempt($query, int $attempts)
    {
        return $query->where('attempts', '>=', $attempts);
    }

    public function scopeNeedsReset($query)
    {
        return $query->where('reset_at', '<=', now());
    }

    public function canAttempt(): bool
    {
        if ($this->attempts >= $this->max_attempts) {
            return false;
        }

        if ($this->reset_at && $this->reset_at->isFuture()) {
            return false;
        }

        return true;
    }

    public function isBlocked(): bool
    {
        return !$this->canAttempt();
    }

    public function recordAttempt(): void
    {
        $this->attempts++;
        
        if ($this->attempts >= $this->max_attempts) {
            $this->reset_at = now()->addMinutes($this->decay_minutes);
        }
        
        $this->save();
    }

    public function reset(): void
    {
        $this->attempts = 0;
        $this->reset_at = null;
        $this->save();
    }

    public function getAttemptsRemainingAttribute(): int
    {
        return max(0, $this->max_attempts - $this->attempts);
    }

    public function getFormattedAttemptsAttribute(): string
    {
        return $this->attempts . '/' . $this->max_attempts;
    }

    public function getFormattedResetAtAttribute(): ?string
    {
        return $this->reset_at ? $this->reset_at->format('d/m/Y H:i:s') : null;
    }

    public function getTimeUntilResetAttribute(): ?string
    {
        if (!$this->reset_at) {
            return null;
        }

        $diff = $this->reset_at->diffForHumans(now());
        
        return $diff;
    }

    public function getResetTimeInSeconds(): int
    {
        if (!$this->reset_at) {
            return 0;
        }

        return $this->reset_at->diffInSeconds(now());
    }

    public static function getOrCreate(string $key, string $identifier = null, int $maxAttempts = 60, int $decayMinutes = 60): self
    {
        return self::firstOrCreate(
            [
                'key' => $key,
                'identifier' => $identifier,
                'max_attempts' => $maxAttempts,
                'decay_minutes' => $decayMinutes,
            ],
            [
                'attempts' => 0,
                'reset_at' => null,
            ]
        );
    }
    public static function checkAndIncrement(string $key, string $identifier = null, int $maxAttempts = 60, int $decayMinutes = 60): bool
    {
        $rateLimit = self::getOrCreate($key, $identifier, $maxAttempts, $decayMinutes);
        
        if (!$rateLimit->canAttempt()) {
            return false;
        }
        
        $rateLimit->recordAttempt();
        
        return true;
    }

    public static function isBlockedKey(string $key, string $identifier = null): bool
    {
        $rateLimit = self::where('key', $key)
                         ->when($identifier, function ($query) use ($identifier) {
                             $query->where('identifier', $identifier);
                         })
                         ->first();
        
        return $rateLimit ? !$rateLimit->canAttempt() : false;
    }

    public static function clear(string $key, string $identifier = null): void
    {
        self::where('key', $key)
            ->when($identifier, function ($query) use ($identifier) {
                $query->where('identifier', $identifier)->delete();
            })->delete();
    }

    public static function clearAll(): void
    {
        self::query()->delete();
    }

    public static function cleanupExpired(): int
    {
        return self::needsReset()->delete();
    }

    public static function getStats(): array
    {
        $total = self::count();
        $blocked = self::where('attempts', '>=', function ($query) {
            $query->where('reset_at', '>', now());
        })->count();
        
        return [
            'total' => $total,
            'blocked' => $blocked,
            'active' => $total - $blocked,
            'blocked_percentage' => $total > 0 ? round(($blocked / $total) * 100, 2) : 0,
        ];
    }

    public static function getTopBlocked(): array
    {
        return self::where('attempts', '>=', function ($query) {
            $query->where('reset_at', '>', now());
        })
        ->orderByDesc('attempts')
        ->limit(10)
        ->get()
        ->map(function ($item) {
            return [
                'key' => $item->key,
                'identifier' => $item->identifier,
                'attempts' => $item->attempts,
                'max_attempts' => $item->max_attempts,
                'formatted_attempts' => $item->formatted_attempts,
                'formatted_reset_at' => $item->formatted_reset_at,
                'time_until_reset' => $item->time_until_reset,
            ];
        })
        ->toArray();
    }

    public static function getTopKeys(): array
    {
        return self::selectRaw('key, COUNT(*) as count')
            ->groupBy('key')
            ->orderByDesc('count')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'key' => $item->key,
                    'count' => $item->count,
                    'blocked_count' => self::where('key', $item->key)
                                             ->where('attempts', '>=', function ($query) {
                                                 $query->where('reset_at', '>', now());
                                             })
                                             ->count(),
                ];
            })
            ->toArray();
    }
}
