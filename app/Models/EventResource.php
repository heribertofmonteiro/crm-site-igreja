<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'title',
        'description',
        'file_path',
        'file_name',
        'file_type',
        'url',
        'file_size',
        'mime_type',
        'is_public',
        'uploaded_by',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'is_public' => 'boolean',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopePrivate($query)
    {
        return $query->where('is_public', false);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('file_type', $type);
    }

    public function getFileUrlAttribute(): ?string
    {
        if ($this->url) {
            return $this->url;
        }
        
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        
        return null;
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
            'mp4', 'avi', 'mov' => 'fas fa-file-video',
            'mp3', 'wav' => 'fas fa-file-audio',
            'zip', 'rar' => 'fas fa-file-archive',
            'link' => 'fas fa-link',
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
            'mp4', 'avi', 'mov' => 'Vídeo',
            'mp3', 'wav' => 'Áudio',
            'zip', 'rar' => 'Arquivo Compactado',
            'link' => 'Link Externo',
            default => ucfirst($this->file_type)
        };
    }

    public function isDownloadable(): bool
    {
        return $this->file_path && !$this->url;
    }

    public function isExternalLink(): bool
    {
        return $this->url !== null;
    }
}
