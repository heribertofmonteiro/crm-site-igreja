<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'report_type',
        'period_start',
        'period_end',
        'generated_by',
        'status',
        'data',
        'file_path',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'data' => 'array',
    ];

    const TYPE_MONTHLY = 'monthly';
    const TYPE_QUARTERLY = 'quarterly';
    const TYPE_ANNUAL = 'annual';
    const TYPE_CUSTOM = 'custom';

    const STATUS_DRAFT = 'draft';
    const STATUS_GENERATED = 'generated';
    const STATUS_APPROVED = 'approved';
    const STATUS_ARCHIVED = 'archived';

    public function scopeByType($query, $type)
    {
        return $query->where('report_type', $type);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPeriod($query, $start, $end)
    {
        return $query->whereBetween('period_start', [$start, $end]);
    }

    public function getFormattedTypeAttribute(): string
    {
        $types = [
            self::TYPE_MONTHLY => 'Mensal',
            self::TYPE_QUARTERLY => 'Trimestral',
            self::TYPE_ANNUAL => 'Anual',
            self::TYPE_CUSTOM => 'Personalizado',
        ];

        return $types[$this->report_type] ?? $this->report_type;
    }

    public function getFormattedStatusAttribute(): string
    {
        $statuses = [
            self::STATUS_DRAFT => 'Rascunho',
            self::STATUS_GENERATED => 'Gerado',
            self::STATUS_APPROVED => 'Aprovado',
            self::STATUS_ARCHIVED => 'Arquivado',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    public function getDurationAttribute(): string
    {
        return $this->period_start->format('d/m/Y') . ' - ' . $this->period_end->format('d/m/Y');
    }
}
