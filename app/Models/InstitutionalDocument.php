<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstitutionalDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'department_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'mime_type',
        'is_public',
        'requires_approval',
        'is_approved',
        'approved_by',
        'approved_at',
        'created_by',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'is_public' => 'boolean',
        'requires_approval' => 'boolean',
        'is_approved' => 'boolean',
        'approved_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(DocumentCategory::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopePrivate($query)
    {
        return $query->where('is_public', false);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePendingApproval($query)
    {
        return $query->where('requires_approval', true)->where('is_approved', false);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    public function getFileUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
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

    public function getIconAttribute(): string
    {
        return match($this->file_type) {
            'pdf' => 'fas fa-file-pdf',
            'doc', 'docx' => 'fas fa-file-word',
            'xls', 'xlsx' => 'fas fa-file-excel',
            'ppt', 'pptx' => 'fas fa-file-powerpoint',
            'jpg', 'jpeg', 'png', 'gif' => 'fas fa-file-image',
            'zip', 'rar' => 'fas fa-file-archive',
            default => 'fas fa-file'
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->file_type) {
            'pdf' => 'PDF',
            'doc', 'docx' => 'Word',
            'xls', 'xlsx' => 'Excel',
            'ppt', 'pptx' => 'PowerPoint',
            'jpg', 'jpeg', 'png', 'gif' => 'Imagem',
            'zip', 'rar' => 'Arquivo Compactado',
            default => ucfirst($this->file_type)
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        if ($this->requires_approval && !$this->is_approved) {
            return '<span class="badge badge-warning">Pendente Aprovação</span>';
        }
        
        if ($this->is_public) {
            return '<span class="badge badge-success">Público</span>';
        }
        
        return '<span class="badge badge-secondary">Privado</span>';
    }

    public function canBeApproved(): bool
    {
        return $this->requires_approval && !$this->is_approved;
    }

    public function isAccessibleByUser(User $user): bool
    {
        if ($this->is_public) {
            return true;
        }
        
        if ($this->department_id && $user->department_id === $this->department_id) {
            return true;
        }
        
        return $user->hasRole('admin') || $this->created_by === $user->id;
    }
}
