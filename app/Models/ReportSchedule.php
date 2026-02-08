<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'report_type',
        'is_active',
        'parameters',
        'recipients',
        'format',
        'scheduled_time',
        'last_run',
        'next_run',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'parameters' => 'array',
        'scheduled_time' => 'time',
        'last_run' => 'date',
        'next_run' => 'date',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByReportType($query, string $reportType)
    {
        return $query->where('report_type', $reportType);
    }

    public function scopePending($query)
    {
        return $query->where('next_run', '<=', now());
    }

    public function scopeDue($query)
    {
        return $query->where('next_run', '<=', now());
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'daily' => 'Diário',
            'weekly' => 'Semanal',
            'monthly' => 'Mensal',
            'quarterly' => 'Trimestral',
            'yearly' => 'Anual',
            default => ucfirst($this->type)
        };
    }

    public function getReportTypeLabelAttribute(): string
    {
        return match($this->report_type) {
            'financial' => 'Financeiro',
            'members' => 'Membros',
            'events' => 'Eventos',
            'worship' => 'Louvor',
            'donations' => 'Doações',
            'attendance' => 'Frequência',
            'custom' => 'Personalizado',
            default => ucfirst($this->report_type)
        };
    }

    public function getFormatLabelAttribute(): string
    {
        return match($this->format) {
            'pdf' => 'PDF',
            'excel' => 'Excel',
            'csv' => 'CSV',
            default => 'PDF'
        };
    }

    public function getFormattedScheduledTimeAttribute(): string
    {
        return $this->scheduled_time->format('H:i');
    }

    public function getFormattedLastRunAttribute(): ?string
    {
        return $this->last_run ? $this->last_run->format('d/m/Y H:i') : null;
    }

    public function getFormattedNextRunAttribute(): ?string
    {
        return $this->next_run ? $this->next_run->format('d/m/Y H:i') : null;
    }

    public function getRecipientsListAttribute(): array
    {
        return $this->recipients ? explode(',', $this->recipients) : [];
    }

    public function getRecipientsCountAttribute(): int
    {
        return count($this->recipients_list);
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function isDue(): bool
    {
        return $this->next_run && $this->next_run->isPast();
    }

    public function canBeRun(): bool
    {
        return $this->isActive() && $this->isDue();
    }

    public function calculateNextRun(): void
    {
        $lastRun = $this->last_run ?? now();
        
        switch ($this->type) {
            case 'daily':
                $nextRun = $lastRun->copy()->addDay();
                break;
            case 'weekly':
                $nextRun = $lastRun->copy()->addWeek();
                break;
            case 'monthly':
                $nextRun = $lastRun->copy()->addMonth();
                break;
            case 'quarterly':
                $nextRun = $lastRun->copy()->addMonths(3);
                break;
            case 'yearly':
                $nextRun = $lastRun->copy()->addYear();
                break;
            default:
                $nextRun = $lastRun->copy()->addDay();
                break;
        }
        
        $this->next_run = $nextRun->setTime($this->scheduled_time);
        $this->save();
    }

    public function markAsRun(): void
    {
        $this->last_run = now();
        $this->calculateNextRun();
    }

    public function getFrequencyInDays(): int
    {
        return match($this->type) {
            'daily' => 1,
            'weekly' => 7,
            'monthly' => 30,
            'quarterly' => 90,
            'yearly' => 365,
            default => 1
        };
    }

    public function getFrequencyLabel(): string
    {
        return match($this->type) {
            'daily' => 'Todos os dias',
            'weekly' => 'Toda semana',
            'monthly' => 'Todo mês',
            'quarterly' => 'Trimestralmente',
            'yearly' => 'Anualmente',
            default => 'Diariamente'
        };
    }

    public function canBeEditedByUser(User $user): bool
    {
        return $user->hasRole('admin') || $this->created_by === $user->id;
    }

    public function canBeDeletedByUser(User $user): bool
    {
        return $user->hasRole('admin') || $this->created_by === $user->id;
    }

    public function toggleStatus(): void
    {
        $this->is_active = !$this->is_active;
        $this->save();
        
        if ($this->is_active) {
            $this->calculateNextRun();
        }
    }
}
