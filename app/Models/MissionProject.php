<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MissionProject extends Model
{
    protected $fillable = [
        'name',
        'description',
        'location',
        'start_date',
        'end_date',
        'budget',
        'missionary_id',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'budget' => 'decimal:2',
    ];

    public function missionary(): BelongsTo
    {
        return $this->belongsTo(Missionary::class);
    }
}
