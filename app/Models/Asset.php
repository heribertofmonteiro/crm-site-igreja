<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category',
        'value',
        'acquisition_date',
        'status',
        'location',
    ];

    protected $casts = [
        'acquisition_date' => 'date',
        'value' => 'decimal:2',
    ];

    public function maintenanceOrders()
    {
        return $this->hasMany(MaintenanceOrder::class);
    }
}
