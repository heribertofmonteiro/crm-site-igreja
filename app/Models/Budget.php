<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'year',
        'planned_amount',
        'actual_amount',
        'status',
        'created_by',
    ];

    protected $casts = [
        'planned_amount' => 'decimal:2',
        'actual_amount' => 'decimal:2',
        'status' => 'string',
    ];

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeByYear($query, int $year)
    {
        return $query->where('year', $year);
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function getFormattedPlannedAmountAttribute(): string
    {
        return 'R$ ' . number_format($this->planned_amount, 2, ',', '.');
    }

    public function getFormattedActualAmountAttribute(): string
    {
        return 'R$ ' . number_format($this->actual_amount, 2, ',', '.');
    }

    public function getVarianceAttribute(): float
    {
        return $this->actual_amount - $this->planned_amount;
    }

    public function getFormattedVarianceAttribute(): string
    {
        $variance = $this->variance;
        $prefix = $variance >= 0 ? '+' : '';
        return $prefix . ' R$ ' . number_format(abs($variance), 2, ',', '.');
    }

    public function getVariancePercentageAttribute(): float
    {
        if ($this->planned_amount == 0) {
            return 0;
        }
        
        return ($this->variance / $this->planned_amount) * 100;
    }

    public function getFormattedVariancePercentageAttribute(): string
    {
        $percentage = $this->variance_percentage;
        $prefix = $percentage >= 0 ? '+' : '';
        return $prefix . number_format($percentage, 2, ',', '.') . '%';
    }

    public function getVarianceStatusAttribute(): string
    {
        $percentage = abs($this->variance_percentage);
        
        if ($percentage <= 5) {
            return 'success'; // Green
        } elseif ($percentage <= 10) {
            return 'warning'; // Yellow
        } else {
            return 'danger'; // Red
        }
    }

    public function getVarianceBadgeAttribute(): string
    {
        $status = $this->variance_status;
        $text = $this->formatted_variance_percentage;
        
        return match($status) {
            'success' => '<span class="badge badge-success">' . $text . '</span>',
            'warning' => '<span class="badge badge-warning">' . $text . '</span>',
            'danger' => '<span class="badge badge-danger">' . $text . '</span>',
            default => '<span class="badge badge-secondary">' . $text . '</span>'
        };
    }

    public function getUtilizationPercentageAttribute(): float
    {
        if ($this->planned_amount == 0) {
            return 0;
        }
        
        return ($this->actual_amount / $this->planned_amount) * 100;
    }

    public function getFormattedUtilizationPercentageAttribute(): string
    {
        return number_format($this->utilization_percentage, 1, ',', '.') . '%';
    }

    public function getPeriodTypeLabelAttribute(): string
    {
        return match($this->period_type) {
            'weekly' => 'Semanal',
            'monthly' => 'Mensal',
            'quarterly' => 'Trimestral',
            'yearly' => 'Anual',
            default => ucfirst($this->period_type)
        };
    }

    public function isOverBudget(): bool
    {
        return $this->actual_amount > $this->planned_amount;
    }

    public function isUnderBudget(): bool
    {
        return $this->actual_amount < $this->planned_amount;
    }

    public function isOnBudget(): bool
    {
        return $this->actual_amount == $this->planned_amount;
    }

    public function updateActualAmount(): void
    {
        // Calculate actual amount from expenses within budget year
        $actualAmount = $this->expenses()
            ->whereYear('date', $this->year)
            ->sum('amount');
            
        $this->actual_amount = $actualAmount;
        $this->save();
    }

    public function getRemainingAmountAttribute(): float
    {
        return $this->planned_amount - $this->actual_amount;
    }

    public function getFormattedRemainingAmountAttribute(): string
    {
        $remaining = $this->remaining_amount;
        $prefix = $remaining >= 0 ? '' : '-';
        return $prefix . ' R$ ' . number_format(abs($remaining), 2, ',', '.');
    }

    public function getProgressPercentageAttribute(): float
    {
        return min(100, $this->utilization_percentage);
    }

    public function getProgressColorAttribute(): string
    {
        $percentage = $this->progress_percentage;
        
        if ($percentage <= 70) {
            return 'success';
        } elseif ($percentage <= 90) {
            return 'warning';
        } else {
            return 'danger';
        }
    }
}
