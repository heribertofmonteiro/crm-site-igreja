<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ApiToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'token',
        'is_active',
        'abilities',
        'expires_at',
        'last_used_at',
        'ip_address',
        'user_agent',
        'user_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'abilities' => 'array',
        'expires_at' => 'datetime',
        'last_used_at' => 'datetime',
    ];

    protected $hidden = [
        'token',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByAbility($query, $ability)
    {
        return $query->whereJsonContains('abilities', $ability);
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isActive(): bool
    {
        return $this->is_active && !$this->isExpired();
    }

    public function isValid(): bool
    {
        return $this->isActive();
    }

    public function hasAbility(string $ability): bool
    {
        return in_array($ability, $this->abilities ?? []);
    }

    public function hasAnyAbility(array $abilities): bool
    {
        return !empty(array_intersect($this->abilities ?? [], $abilities));
    }

    public function hasAllAbilities(array $abilities): bool
    {
        $tokenAbilities = $this->abilities ?? [];
        
        foreach ($abilities as $ability) {
            if (!in_array($ability, $tokenAbilities)) {
                return false;
            }
        }
        
        return true;
    }

    public function addAbility(string $ability): void
    {
        $abilities = $this->abilities ?? [];
        
        if (!in_array($ability, $abilities)) {
            $abilities[] = $ability;
            $this->abilities = $abilities;
            $this->save();
        }
    }

    public function removeAbility(string $ability): void
    {
        $abilities = $this->abilities ?? [];
        
        $key = array_search($ability, $abilities);
        if ($key !== false) {
            unset($abilities[$key]);
            $this->abilities = array_values($abilities);
            $this->save();
        }
    }

    public function setAbilities(array $abilities): void
    {
        $this->abilities = $abilities;
        $this->save();
    }

    public function getAbilitiesListAttribute(): array
    {
        return $this->abilities ?? [];
    }

    public function getFormattedAbilitiesAttribute(): string
    {
        $abilities = $this->abilities_list;
        
        if (empty($abilities)) {
            return 'Nenhuma';
        }
        
        return implode(', ', array_map('ucfirst', $abilities));
    }

    public function getFormattedExpiresAtAttribute(): ?string
    {
        return $this->expires_at ? $this->expires_at->format('d/m/Y H:i') : null;
    }

    public function getFormattedLastUsedAtAttribute(): ?string
    {
        return $this->last_used_at ? $this->last_used_at->format('d/m/Y H:i') : null;
    }

    public function getStatusBadgeAttribute(): string
    {
        if (!$this->is_active) {
            return '<span class="badge badge-danger">Inativo</span>';
        }
        
        if ($this->isExpired()) {
            return '<span class="badge badge-warning">Expirado</span>';
        }
        
        return '<span class="badge badge-success">Ativo</span>';
    }

    public function markAsUsed($ipAddress = null, $userAgent = null): void
    {
        $this->last_used_at = now();
        
        if ($ipAddress) {
            $this->ip_address = $ipAddress;
        }
        
        if ($userAgent) {
            $this->user_agent = $userAgent;
        }
        
        $this->save();
    }

    public function deactivate(): void
    {
        $this->is_active = false;
        $this->save();
    }

    public function activate(): void
    {
        $this->is_active = true;
        $this->save();
    }

    public function extendExpiration(int $days): void
    {
        if ($this->expires_at) {
            $this->expires_at = $this->expires_at->addDays($days);
        } else {
            $this->expires_at = now()->addDays($days);
        }
        
        $this->save();
    }

    public function revoke(): void
    {
        $this->is_active = false;
        $this->token = null;
        $this->save();
    }

    public static function generateToken(): string
    {
        return Str::random(60);
    }

    public static function createForUser(User $user, string $name = null, array $abilities = [], $expiresInDays = null): self
    {
        return self::create([
            'name' => $name ?: 'Token API',
            'token' => self::generateToken(),
            'abilities' => $abilities,
            'expires_at' => $expiresInDays ? now()->addDays($expiresInDays) : null,
            'user_id' => $user->id,
        ]);
    }

    public static function findByToken(string $token): ?self
    {
        return self::where('token', $token)->first();
    }

    public static function findValidByToken(string $token): ?self
    {
        return self::where('token', $token)
                   ->active()
                   ->notExpired()
                   ->first();
    }

    public static function cleanupExpired(): int
    {
        return self::expired()->delete();
    }

    public static function cleanupInactive(): int
    {
        return self::where('is_active', false)->delete();
    }

    public static function cleanupOld(int $days = 90): int
    {
        return self::where('created_at', '<', now()->subDays($days))->delete();
    }

    public static function getUsageStats(): array
    {
        $total = self::count();
        $active = self::active()->count();
        $expired = self::expired()->count();
        $inactive = self::where('is_active', false)->count();
        
        return [
            'total' => $total,
            'active' => $active,
            'expired' => $expired,
            'inactive' => $inactive,
            'active_percentage' => $total > 0 ? round(($active / $total) * 100, 2) : 0,
        ];
    }

    public function canBeEditedByUser(User $user): bool
    {
        return $user->hasRole('admin') || $this->user_id === $user->id;
    }

    public function canBeDeletedByUser(User $user): bool
    {
        return $user->hasRole('admin') || $this->user_id === $user->id;
    }

    public function getShortTokenAttribute(): string
    {
        return substr($this->token, 0, 8) . '...';
    }

    public function getMaskedTokenAttribute(): string
    {
        return substr($this->token, 0, 12) . str_repeat('*', strlen($this->token) - 12);
    }

    public function getApiUrlAttribute(): string
    {
        return config('app.url') . '/api/v1';
    }

    public function getAuthorizationHeader(): string
    {
        return 'Bearer ' . $this->token;
    }

    public function toArray()
    {
        $array = parent::toArray();
        
        // Hide sensitive data
        $array['token'] = $this->masked_token;
        
        return $array;
    }
}
