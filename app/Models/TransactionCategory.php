<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransactionCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'type',
        'color',
        'icon',
        'is_active',
        'is_default',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(FinancialTransaction::class);
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }

    public function scopeTransfer($query)
    {
        return $query->where('type', 'transfer');
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'income' => 'Receita',
            'expense' => 'Despesa',
            'transfer' => 'Transferência',
            default => ucfirst($this->type)
        };
    }

    public function getTypeIconAttribute(): string
    {
        return match($this->type) {
            'income' => 'fas fa-arrow-up text-success',
            'expense' => 'fas fa-arrow-down text-danger',
            'transfer' => 'fas fa-exchange-alt text-info',
            default => 'fas fa-circle text-muted'
        };
    }

    public function getTransactionCountAttribute(): int
    {
        return $this->transactions()->count();
    }

    public function getTotalAmountAttribute(): float
    {
        return $this->transactions()->sum('amount');
    }

    public function getFormattedTotalAmountAttribute(): string
    {
        return number_format($this->total_amount, 2, ',', '.');
    }

    protected static function booted()
    {
        static::creating(function ($category) {
            $category->slug = \Illuminate\Support\Str::slug($category->name);
        });
        
        static::updating(function ($category) {
            if ($category->isDirty('name')) {
                $category->slug = \Illuminate\Support\Str::slug($category->name);
            }
        });
    }
}
