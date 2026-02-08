<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'amount',
        'date',
        'category',
        'vendor',
        'receipt_number',
        'notes',
        'approved',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'date',
        'approved' => 'boolean',
        'approved_at' => 'datetime',
    ];

    protected $dates = [
        'approved_at',
    ];

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('approved', false);
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'R$ ' . number_format($this->amount, 2, ',', '.');
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->date->format('d/m/Y');
    }

    public function getCategoryNameAttribute(): string
    {
        return match($this->category) {
            'utilities' => 'Utilidades',
            'rent' => 'Aluguel',
            'supplies' => 'Suprimentos',
            'marketing' => 'Marketing',
            'events' => 'Eventos',
            'staff' => 'Pessoal',
            'other' => 'Outros',
            default => 'Outros',
        };
    }

    public function getApprovalStatusAttribute(): string
    {
        return $this->approved ? 'Aprovado' : 'Pendente';
    }

    public function approve(int $approvedBy): void
    {
        $this->update([
            'approved' => true,
            'approved_by' => $approvedBy,
            'approved_at' => now(),
        ]);
    }
}
