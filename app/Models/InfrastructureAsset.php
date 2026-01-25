<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfrastructureAsset extends Model
{
    protected $fillable = [
        'name',
        'type',
        'status',
        'location',
        'purchase_date',
        'warranty_expiry',
        'notes',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'warranty_expiry' => 'date',
    ];
}
