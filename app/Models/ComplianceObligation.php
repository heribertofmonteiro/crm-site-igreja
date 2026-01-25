<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComplianceObligation extends Model
{
    protected $fillable = [
        'title',
        'description',
        'obligation_type',
        'due_date',
        'status',
        'responsible_user_id',
        'notes',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function responsibleUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_user_id');
    }
}
