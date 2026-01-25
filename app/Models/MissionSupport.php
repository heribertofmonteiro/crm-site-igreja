<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MissionSupport extends Model
{
    protected $fillable = [
        'missionary_id',
        'supporter_id',
        'amount',
        'frequency',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function missionary(): BelongsTo
    {
        return $this->belongsTo(Missionary::class);
    }

    public function supporter(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'supporter_id');
    }
}
