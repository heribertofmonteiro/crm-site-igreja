<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PastoralNote extends Model
{
    protected $fillable = [
        'title',
        'content',
        'council_id',
        'user_id',
        'type',
    ];

    public function council(): BelongsTo
    {
        return $this->belongsTo(PastoralCouncil::class, 'council_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
