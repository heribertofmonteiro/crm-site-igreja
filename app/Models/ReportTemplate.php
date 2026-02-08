<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'is_active',
        'is_default',
        'template_config',
        'fields',
        'header_template',
        'footer_template',
        'content_template',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'template_config' => 'array',
        'fields' => 'array',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function generatedReports(): HasMany
    {
        return $this->hasMany(GeneratedReport::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
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

    public function getFieldsDefinition(): array
    {
        return $this->fields ?? [];
    }

    public function getTemplateConfig(): array
    {
        return $this->template_config ?? [];
    }

    public function getHeaderTemplate(): ?string
    {
        return $this->header_template;
    }

    public function getFooterTemplate(): ?string
    {
        return $this->footer_template;
    }

    public function getContentTemplate(): ?string
    {
        return $this->content_template;
    }

    public function getFieldValue(string $fieldName): mixed
    {
        return data_get($this->fields, $fieldName);
    }

    public function hasField(string $fieldName): bool
    {
        return array_key_exists($fieldName, $this->fields);
    }

    public function getFieldLabel(string $fieldName): ?string
    {
        $field = $this->getFieldValue($fieldName);
        
        if (is_array($field)) {
            return $field['label'] ?? null;
        }
        
        return $field;
    }

    public function getFieldType(string $fieldName): ?string
    {
        $field = $this->getFieldValue($fieldName);
        
        if (is_array($field)) {
            return $field['type'] ?? 'text';
        }
        
        return 'text';
    }

    public function getFieldOptions(string $fieldName): array
    {
        $field = $this->getFieldValue($fieldName);
        
        if (is_array($field)) {
            return $field['options'] ?? [];
        }
        
        return [];
    }

    public function isDefault(): bool
    {
        return $this->is_default;
    }

    public function canBeEditedByUser(User $user): bool
    {
        return $user->hasRole('admin') || $this->created_by === $user->id;
    }

    public function canBeDeletedByUser(User $user): bool
    {
        return $user->hasRole('admin') || $this->created_by === $user->id;
    }

    public function canBeMadeDefault(): bool
    {
        return !$this->is_default;
    }

    public function makeDefault(): void
    {
        // Remove default status from all other templates of same type
        self::where('type', $this->type)
            ->where('id', '!=', $this->id)
            ->update(['is_default' => false]);
        
        $this->is_default = true;
        $this->save();
    }

    public function render(array $data = []): string
    {
        $content = $this->content_template ?? '';

        // Replace placeholders with actual data
        foreach ($data as $key => $value) {
            $content = str_replace('{' . $key . '}', $value, $content);
        }

        return $content;
    }

    public function generateReport(array $parameters = []): array
    {
        // This method would contain the logic to generate the report data
        // Implementation would depend on the report type and template
        return [];
    }

    public function getRequiredParameters(): array
    {
        $config = $this->template_config;
        return $config['required_parameters'] ?? [];
    }

    public function getOptionalParameters(): array
    {
        $config = $this->template_config;
        return $config['optional_parameters'] ?? [];
    }

    public function validateParameters(array $parameters): array
    {
        $required = $this->getRequiredParameters();
        $optional = $this->getOptionalParameters();
        
        $errors = [];
        
        foreach ($required as $param) {
            if (!isset($parameters[$param])) {
                $errors[] = "Parâmetro obrigatório: {$param}";
            }
        }
        
        return $errors;
    }

    public function getParameterDefaults(): array
    {
        $config = $this->template_config;
        return $config['parameter_defaults'] ?? [];
    }

    public function applyParameterDefaults(array &$parameters): void
    {
        $defaults = $this->getParameterDefaults();
        
        foreach ($defaults as $key => $value) {
            if (!isset($parameters[$key])) {
                $parameters[$key] = $value;
            }
        }
    }

    public function getReportTitle(array $parameters = []): string
    {
        $title = $this->name;
        
        if (isset($parameters['start_date'])) {
            $title .= ' - ' . $parameters['start_date'];
        }
        
        if (isset($parameters['end_date'])) {
            $title .= ' a ' . $parameters['end_date'];
        }
        
        return $title;
    }

    public function getReportFileName(array $parameters = []): string
    {
        $title = $this->getReportTitle($parameters);
        $date = now()->format('Y-m-d_H-i-s');
        $format = $this->format ?? 'pdf';
        
        return Str::slug($title) . '_' . $date . '.' . $format;
    }

    public function getReportFilePath(array $parameters = []): string
    {
        $fileName = $this->getReportFileName($parameters);
        $date = now()->format('Y/m');
        
        return "reports/{$date}/{$fileName}";
    }

    public function getReportUrl(array $parameters = []): string
    {
        $filePath = $this->getReportFilePath($parameters);
        
        return asset($filePath);
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
