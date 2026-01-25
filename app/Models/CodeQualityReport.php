<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CodeQualityReport extends Model
{
    protected $fillable = [
        'scan_date',
        'total_files',
        'average_complexity',
        'technical_debt_hours',
        'duplicated_lines',
        'metrics',
    ];

    protected function casts(): array
    {
        return [
            'scan_date' => 'datetime',
            'metrics' => 'array',
        ];
    }
}
