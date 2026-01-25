<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpansionProject extends Model
{
    protected $fillable = [
        'name',
        'description',
        'budget',
        'status',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'budget' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}
