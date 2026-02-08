<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinancialTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'amount',
        'type',
        'category_id',
        'account_id',
        'transfer_account_id',
        'transaction_date',
        'is_reconciled',
        'reconciled_at',
        'reconciled_by',
        'notes',
        'metadata',
        'created_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
        'is_reconciled' => 'boolean',
        'reconciled_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(TransactionCategory::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(FinancialAccount::class);
    }

    public function transferAccount(): BelongsTo
    {
        return $this->belongsTo(FinancialAccount::class, 'transfer_account_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reconciler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reconciled_by');
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

    public function scopeReconciled($query)
    {
        return $query->where('is_reconciled', true);
    }

    public function scopeUnreconciled($query)
    {
        return $query->where('is_reconciled', false);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('transaction_date', [$startDate, $endDate]);
    }

    public function scopeByAccount($query, $accountId)
    {
        return $query->where('account_id', $accountId);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function getFormattedAmountAttribute(): string
    {
        $prefix = $this->type === 'expense' ? '-' : '+';
        return $prefix . ' R$ ' . number_format($this->amount, 2, ',', '.');
    }

    public function getFormattedAmountWithoutSignAttribute(): string
    {
        return 'R$ ' . number_format($this->amount, 2, ',', '.');
    }

    public function getFormattedTransactionDateAttribute(): string
    {
        return $this->transaction_date->format('d/m/Y');
    }

    public function getTypeBadgeAttribute(): string
    {
        return match($this->type) {
            'income' => '<span class="badge badge-success">Receita</span>',
            'expense' => '<span class="badge badge-danger">Despesa</span>',
            'transfer' => '<span class="badge badge-info">Transferência</span>',
            default => '<span class="badge badge-secondary">' . $this->type . '</span>'
        };
    }

    public function getReconciliationStatusAttribute(): string
    {
        if ($this->is_reconciled) {
            return '<span class="badge badge-success">Conciliado</span>';
        }
        
        return '<span class="badge badge-warning">Pendente</span>';
    }

    public function getPaymentMethodAttribute(): ?string
    {
        return $this->metadata['payment_method'] ?? null;
    }

    public function getReferenceAttribute(): ?string
    {
        return $this->metadata['reference'] ?? null;
    }

    public function getDonorNameAttribute(): ?string
    {
        return $this->metadata['donor_name'] ?? null;
    }

    public function getDonorEmailAttribute(): ?string
    {
        return $this->metadata['donor_email'] ?? null;
    }

    public function getDonationTypeAttribute(): ?string
    {
        return $this->metadata['donation_type'] ?? null;
    }

    public function isIncome(): bool
    {
        return $this->type === 'income';
    }

    public function isExpense(): bool
    {
        return $this->type === 'expense';
    }

    public function isTransfer(): bool
    {
        return $this->type === 'transfer';
    }

    public function canBeReconciled(): bool
    {
        return !$this->is_reconciled;
    }

    public function canBeUnreconciled(): bool
    {
        return $this->is_reconciled;
    }

    public function reconcile(User $user): void
    {
        $this->update([
            'is_reconciled' => true,
            'reconciled_at' => now(),
            'reconciled_by' => $user->id,
        ]);
    }

    public function unreconcile(): void
    {
        $this->update([
            'is_reconciled' => false,
            'reconciled_at' => null,
            'reconciled_by' => null,
        ]);
    }

    protected static function booted()
    {
        static::created(function ($transaction) {
            // Update account balance
            if ($transaction->account) {
                $transaction->account->updateBalance();
            }
            
            // Update transfer account balance if applicable
            if ($transaction->transferAccount && $transaction->isTransfer()) {
                $transaction->transferAccount->updateBalance();
            }
        });
        
        static::updated(function ($transaction) {
            // Update account balance if amount or type changed
            if ($transaction->wasChanged(['amount', 'type', 'account_id', 'transfer_account_id'])) {
                if ($transaction->account) {
                    $transaction->account->updateBalance();
                }
                
                if ($transaction->transferAccount) {
                    $transaction->transferAccount->updateBalance();
                }
            }
        });
        
        static::deleted(function ($transaction) {
            // Update account balance
            if ($transaction->account) {
                $transaction->account->updateBalance();
            }
            
            // Update transfer account balance if applicable
            if ($transaction->transferAccount && $transaction->isTransfer()) {
                $transaction->transferAccount->updateBalance();
            }
        });
    }
}
