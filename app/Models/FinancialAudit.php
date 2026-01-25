<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialAudit extends Model
{
    protected $fillable = [
        'audit_date',
        'period_start',
        'period_end',
        'findings',
        'recommendations',
        'status',
        'auditor',
    ];

    protected $casts = [
        'audit_date' => 'date',
        'period_start' => 'date',
        'period_end' => 'date',
    ];
}
