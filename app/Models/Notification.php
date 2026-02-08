<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'type',
        'is_read',
        'user_id',
        'related_type',
        'related_id',
        'data',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeRelatedTo($query, string $type, $id)
    {
        return $query->where('related_type', $type)
                   ->where('related_id', $id);
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'info' => 'Informação',
            'success' => 'Sucesso',
            'warning' => 'Aviso',
            'error' => 'Erro',
            'system' => 'Sistema',
            default => ucfirst($this->type)
        };
    }

    public function getTypeIconAttribute(): string
    {
        return match($this->type) {
            'info' => 'fas fa-info-circle text-info',
            'success' => 'fas fa-check-circle text-success',
            'warning' => 'fas fa-exclamation-triangle text-warning',
            'error' => 'fas fa-times-circle text-danger',
            'system' => 'fas fa-cog text-secondary',
            default => 'fas fa-bell text-muted'
        };
    }

    public function getTypeColorAttribute(): string
    {
        return match($this->type) {
            'info' => '#17a2b8',
            'success' => '#28a745',
            'warning' => '#ffc107',
            'error' => '#dc3545',
            'system' => '#6c757d',
            default => '#6c757d'
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        if ($this->is_read) {
            return '<span class="badge badge-secondary">Lida</span>';
        }
        
        return '<span class="badge badge-primary">Nova</span>';
    }

    public function isUnread(): bool
    {
        return !$this->is_read;
    }

    public function isRead(): bool
    {
        return $this->is_read;
    }

    public function markAsRead(): void
    {
        if (!$this->is_read) {
            $this->is_read = true;
            $this->read_at = now();
            $this->save();
        }
    }

    public function markAsUnread(): void
    {
        if ($this->is_read) {
            $this->is_read = false;
            $this->read_at = null;
            $this->save();
        }
    }

    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    public function getFormattedReadAtAttribute(): ?string
    {
        return $this->read_at ? $this->read_at->format('d/m/Y H:i') : null;
    }

    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    public function getDataValue(string $key): mixed
    {
        return data_get($this->data, $key);
    }

    public function hasDataKey(string $key): bool
    {
        return array_key_exists($key, $this->data ?? []);
    }

    public function getRelatedModel(): ?Model
    {
        if (!$this->related_type || !$this->related_id) {
            return null;
        }

        $modelClass = 'App\\Models\\' . $this->related_type;
        
        if (!class_exists($modelClass)) {
            return null;
        }

        return $modelClass::find($this->related_id);
    }

    public function getRelatedUrlAttribute(): ?string
    {
        $model = $this->getRelatedModel();
        
        if (!$model) {
            return null;
        }

        // This would need to be implemented based on your routing structure
        // For now, return a generic URL pattern
        return '/admin/' . strtolower($this->related_type) . '/' . $this->related_id;
    }

    public function getRelatedTitleAttribute(): ?string
    {
        $model = $this->getRelatedModel();
        
        if (!$model) {
            return null;
        }

        return method_exists($model, 'title') ? $model->title : 
               (method_exists($model, 'name') ? $model->name : 
               '#' . $model->id);
    }

    public function canBeMarkedAsRead(): bool
    {
        return $this->isUnread();
    }

    public function canBeMarkedAsUnread(): bool
    {
        return $this->isRead();
    }

    public function canBeDeleted(): bool
    {
        return true; // All notifications can be deleted by their owner
    }

    public function canBeDeletedByUser(User $user): bool
    {
        return $this->user_id === $user->id || $user->hasRole('admin');
    }

    public static function createForUser(User $user, string $title, string $message, string $type = 'info', array $data = []): self
    {
        return self::create([
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'user_id' => $user->id,
            'data' => $data,
        ]);
    }

    public static function createRelated(Model $model, User $user, string $title, string $message, string $type = 'info', array $data = []): self
    {
        return self::create([
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'user_id' => $user->id,
            'related_type' => class_basename($model),
            'related_id' => $model->id,
            'data' => $data,
        ]);
    }

    public static function createSystem(string $title, string $message, array $data = []): self
    {
        return self::create([
            'title' => $title,
            'message' => $message,
            'type' => 'system',
            'user_id' => null, // System notifications can be global
            'data' => $data,
        ]);
    }

    public static function createForAllUsers(string $title, string $message, string $type = 'info', array $data = []): void
    {
        User::chunk(100, function ($users) use ($title, $message, $type, $data) {
            foreach ($users as $user) {
                self::createForUser($user, $title, $message, $type, $data);
            }
        });
    }

    public static function createForRole(string $role, string $title, string $message, string $type = 'info', array $data = []): void
    {
        User::where('role', $role)->chunk(100, function ($users) use ($title, $message, $type, $data) {
            foreach ($users as $user) {
                self::createForUser($user, $title, $message, $type, $data);
            }
        });
    }

    public static function unreadCountForUser(User $user): int
    {
        return self::where('user_id', $user->id)
                   ->where('is_read', false)
                   ->count();
    }

    public static function markAllAsReadForUser(User $user): int
    {
        return self::where('user_id', $user->id)
                   ->where('is_read', false)
                   ->update([
                       'is_read' => true,
                       'read_at' => now(),
                   ]);
    }

    public static function cleanupOldNotifications(int $days = 30): int
    {
        return self::where('created_at', '<', now()->subDays($days))
                   ->delete();
    }

    public static function cleanupReadNotifications(int $days = 7): int
    {
        return self::where('is_read', true)
                   ->where('read_at', '<', now()->subDays($days))
                   ->delete();
    }
}
