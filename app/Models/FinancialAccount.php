<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinancialAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'account_type',
        'bank_name',
        'agency_number',
        'account_number',
        'opening_balance',
        'current_balance',
        'currency',
        'responsible_id',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'opening_balance' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(FinancialTransaction::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('account_type', $type);
    }

    public function getFormattedCurrentBalanceAttribute(): string
    {
        return number_format($this->current_balance, 2, ',', '.');
    }

    public function getFormattedOpeningBalanceAttribute(): string
    {
        return number_format($this->opening_balance, 2, ',', '.');
    }

    public function getAccountTypeLabelAttribute(): string
    {
        return match($this->account_type) {
            'checking' => 'Conta Corrente',
            'savings' => 'Poupança',
            'investment' => 'Investimento',
            'credit_card' => 'Cartão de Crédito',
            default => ucfirst($this->account_type)
        };
    }

    public function getAccountTypeIconAttribute(): string
    {
        return match($this->account_type) {
            'checking' => 'fas fa-university',
            'savings' => 'fas fa-piggy-bank',
            'investment' => 'fas fa-chart-line',
            'credit_card' => 'fas fa-credit-card',
            default => 'fas fa-wallet'
        };
    }

    public function updateBalance(): void
    {
        $totalIncome = $this->transactions()
            ->where('type', 'income')
            ->sum('amount');
            
        $totalExpense = $this->transactions()
            ->where('type', 'expense')
            ->sum('amount');
            
        $this->current_balance = $this->opening_balance + $totalIncome - $totalExpense;
        $this->save();
    }

    public function getTransactionCountAttribute(): int
    {
        return $this->transactions()->count();
    }

    public function getLastTransactionAttribute(): ?FinancialTransaction
    {
        return $this->transactions()
            ->latest('transaction_date')
            ->first();
    }

    public function canBeDeleted(): bool
    {
        return !$this->transactions()->exists();
    }
}
