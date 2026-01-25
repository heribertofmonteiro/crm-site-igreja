<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceOrder extends Model
{
    protected $fillable = [
        'asset_id',
        'description',
        'priority',
        'status',
        'scheduled_date',
        'completed_date',
        'assigned_to',
        'notes',
    ];

    protected $casts = [
        'scheduled_date' => 'datetime',
        'completed_date' => 'datetime',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
