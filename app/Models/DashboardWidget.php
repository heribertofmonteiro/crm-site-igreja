<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DashboardWidget extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'is_active',
        'position',
        'order',
        'config',
        'data',
        'size',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'config' => 'array',
        'data' => 'array',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByPosition($query, string $position)
    {
        return $query->where('position', $position);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'chart' => 'Gráfico',
            'metric' => 'Métrica',
            'table' => 'Tabela',
            'custom' => 'Personalizado',
            default => ucfirst($this->type)
        };
    }

    public function getSizeLabelAttribute(): string
    {
        return match($this->size) {
            'small' => 'Pequeno',
            'medium' => 'Médio',
            'large' => 'Grande',
            default => 'Médio'
        };
    }

    public function getPositionLabelAttribute(): string
    {
        return match($this->position) {
            'top' => 'Topo',
            'sidebar' => 'Barra Lateral',
            'main' => 'Principal',
            default => 'Principal'
        };
    }

    public function getIconAttribute(): string
    {
        return match($this->type) {
            'chart' => 'fas fa-chart-bar',
            'metric' => 'fas fa-tachometer-alt',
            'table' => 'fas fa-table',
            'custom' => 'fas fa-cog',
            default => 'fas fa-question-circle'
        };
    }

    public function getColorAttribute(): string
    {
        return $this->config['color'] ?? '#6c757d';
    }

    public function getBackgroundColorAttribute(): string
    {
        return $this->config['background_color'] ?? '#ffffff';
    }

    public function getDataValue(string $key): mixed
    {
        return data_get($this->data, $key);
    }

    public function getConfigValue(string $key): mixed
    {
        return data_get($this->config, $key);
    }

    public function updateData(array $data): void
    {
        $this->data = array_merge($this->data ?? [], $data);
        $this->save();
    }

    public function updateConfig(array $config): void
    {
        $this->config = array_merge($this->config ?? [], $config);
        $this->save();
    }

    public function render(): string
    {
        // This method would contain the logic to render the widget
        // Implementation would depend on the widget type
        return '';
    }

    public function canBeEditedByUser(User $user): bool
    {
        return $user->hasRole('admin') || $this->created_by === $user->id;
    }

    public function canBeDeletedByUser(User $user): bool
    {
        return $user->hasRole('admin') || $this->created_by === $user->id;
    }

    public function isChart(): bool
    {
        return $this->type === 'chart';
    }

    public function isMetric(): bool
    {
        return $this->type === 'metric';
    }

    public function isTable(): bool
    {
        return $this->type === 'table';
    }

    public function isCustom(): bool
    {
        return $this->type === 'custom';
    }

    public function getChartType(): ?string
    {
        return $this->isChart() ? $this->getConfigValue('chart_type') : null;
    }

    public function getMetricValue(): mixed
    {
        return $this->isMetric() ? $this->getDataValue('value') : null;
    }

    public function getMetricLabel(): ?string
    {
        return $this->isMetric() ? $this->getConfigValue('label') : null;
    }

    public function getMetricFormat(): ?string
    {
        return $this->isMetric() ? $this->getConfigValue('format') : null;
    }

    public function getFormattedMetricValue(): string
    {
        if (!$this->isMetric()) {
            return '--';
        }

        $value = $this->getMetricValue();
        $format = $this->getMetricFormat();

        if ($format === 'currency') {
            return 'R$ ' . number_format($value, 2, ',', '.');
        }

        if ($format === 'percentage') {
            return number_format($value, 1, ',', '.') . '%';
        }

        if ($format === 'number') {
            return number_format($value, 2, ',', '.');
        }

        return (string) $value;
    }

    public function getTableHeaders(): array
    {
        return $this->isTable() ? $this->getConfigValue('headers') : [];
    }

    public function getTableData(): array
    {
        return $this->isTable() ? $this->getDataValue('rows') : [];
    }

    public function getCustomContent(): ?string
    {
        return $this->isCustom() ? $this->getDataValue('content') : null;
    }
}
