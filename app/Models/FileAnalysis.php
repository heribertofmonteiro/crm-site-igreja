<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileAnalysis extends Model
{
    protected $fillable = [
        'file_path',
        'grade',
        'complexity',
        'lines_of_code',
        'issues_count',
        'maintainability_index',
        'issues',
        'last_analyzed',
    ];

    protected function casts(): array
    {
        return [
            'issues' => 'array',
            'last_analyzed' => 'datetime',
        ];
    }
}
