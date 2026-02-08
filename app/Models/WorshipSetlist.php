<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WorshipSetlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'church_event_id',
        'date',
        'theme',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'church_event_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function songs(): BelongsToMany
    {
        return $this->belongsToMany(WorshipSong::class, 'worship_setlist_items')
            ->withPivot('order', 'notes', 'key_override')
            ->orderBy('order');
    }

    public function getTotalDurationAttribute(): int
    {
        return $this->songs()->sum('duration') ?? 0;
    }

    public function getFormattedTotalDurationAttribute(): string
    {
        $totalSeconds = $this->total_duration;
        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $seconds = $totalSeconds % 60;
        
        if ($hours > 0) {
            return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        }
        
        return sprintf('%02d:%02d', $minutes, $seconds);
    }

    public function getSongCountAttribute(): int
    {
        return $this->songs()->count();
    }

    public function scopeByDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    public function scopeByMonth($query, $year, $month)
    {
        return $query->whereYear('date', $year)->whereMonth('date', $month);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('date', 'desc');
    }
}
