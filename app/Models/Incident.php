<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Incident extends Model
{
    protected $fillable = [
        'user_id',
        'level',
        'message',
        'stack_trace',
        'status',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    public static function logIncident($level, $message, $stackTrace = null, $userId = null)
    {
        return self::create([
            'user_id' => $userId ?: auth()->id(),
            'level' => $level,
            'message' => $message,
            'stack_trace' => $stackTrace,
        ]);
    }
}
