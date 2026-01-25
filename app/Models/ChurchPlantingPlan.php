<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChurchPlantingPlan extends Model
{
    protected $fillable = [
        'name',
        'description',
        'location',
        'planned_start_date',
        'planned_end_date',
        'status',
        'budget',
        'leader_id',
    ];

    protected $casts = [
        'planned_start_date' => 'date',
        'planned_end_date' => 'date',
        'budget' => 'decimal:2',
    ];

    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }
}
