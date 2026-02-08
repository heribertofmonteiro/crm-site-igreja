<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GeneratedReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'status',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'data',
        'parameters',
        'generated_at',
        'expires_at',
        'template_id',
        'generated_by',
    ];

    protected $casts = [
        'data' => 'array',
        'parameters' => 'array',
        'generated_at' => 'datetime',
        'expires_at' => 'datetime',
        'file_size' => 'integer',
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(ReportTemplate::class);
    }

    public function generator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'generated_by');
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeGenerating($query)
    {
        return $query->where('status', 'generating');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
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

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'financial' => 'Financeiro',
            'members' => 'Membros',
            'events' => 'Eventos',
            'worship' => 'Louvor',
            'donations' => 'Doações',
            'attendance' => 'Frequência',
            'custom' => 'Personalizado',
            default => ucfirst($this->type)
        };
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isExpiredSoon(): bool
    {
        if (!$this->expires_at) {
            return false;
        }
        
        return $this->expires_at->diffInDays(now()) <= 7;
    }

    public function getExpirationStatusAttribute(): string
    {
        if (!$this->expires_at) {
            return '<span class="badge badge-success">Sem expiração</span>';
        }
        
        if ($this->isExpired()) {
            return '<span class="badge badge-danger">Expirado</span>';
        }
        
        if ($this->isExpiredSoon()) {
            return '<span class="badge badge-warning">Expira em breve</span>';
        }
        
        return '<span class="badge badge-success">Ativo</span>';
    }

    public function canBeDownloaded(): bool
    {
        return $this->status === 'completed' && $this->file_path && !$this->isExpired();
    }

    public function getFormattedFileSizeAttribute(): string
    {
        if (!$this->file_size) {
            return '--';
        }
        
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    public function getFormattedGeneratedAtAttribute(): ?string
    {
        return $this->generated_at ? $this->generated_at->format('d/m/Y H:i') : null;
    }

    public function getFormattedExpiresAtAttribute(): ?string
    {
        return $this->expires_at ? $this->expires_at->format('d/m/Y H:i') : null;
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => '<span class="badge badge-warning">Pendente</span>',
            'generating' => '<span class="badge badge-info">Gerando</span>',
            'completed' => '<span class="badge badge-success">Concluído</span>',
            'failed' => '<span class="badge badge-danger">Falhou</span>',
            default => '<span class="badge badge-secondary">' . $this->status . '</span>'
        };
    }

    public function canBeEditedByUser(User $user): bool
    {
        return $user->hasRole('admin') || $this->generated_by === $user->id;
    }

    public function canBeDeletedByUser(User $user): bool
    {
        return $user->hasRole('admin') || $this->generated_by === $user->id;
    }

    public function markAsCompleted(): void
    {
        $this->status = 'completed';
        $this->generated_at = now();
        $this->save();
    }

    public function markAsFailed(string $error = ''): void
    {
        $this->status = 'failed';
        $this->generated_at = null;
        $this->save();
        
        if ($error) {
            $this->data['error'] = $error;
            $this->save();
        }
    }

    public function markAsGenerating(): void
    {
        $this->status = 'generating';
        $this->generated_at = null;
        $this->save();
    }

    public function markAsPending(): void
    {
        $this->status = 'pending';
        $this->generated_at = null;
        $this->save();
    }

    public function deleteFile(): void
    {
        if ($this->file_path && file_exists(public_path($this->file_path))) {
            unlink(public_path($this->file_path));
        }
    }

    public function getFileUrlAttribute(): ?string
    {
        return $this->file_path ? asset($this->file_path) : null;
    }

    public function getDownloadUrlAttribute(): ?string
    {
        return $this->getFileUrl();
    }
}
