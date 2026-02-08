<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WorshipSong extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'artist',
        'key',
        'bpm',
        'duration',
        'lyrics',
        'chords',
        'ccli_number',
        'youtube_link',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'bpm' => 'integer',
        'duration' => 'integer',
        'is_active' => 'boolean',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function setlists(): BelongsToMany
    {
        return $this->belongsToMany(WorshipSetlist::class, 'worship_setlist_items')
            ->withPivot('order', 'notes', 'key_override')
            ->orderBy('order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByKey($query, string $key)
    {
        return $query->where('key', $key);
    }

    public function scopeByArtist($query, string $artist)
    {
        return $query->where('artist', 'like', "%{$artist}%");
    }

    public function getFormattedDurationAttribute(): string
    {
        if (!$this->duration) {
            return '--:--';
        }
        
        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;
        
        return sprintf('%02d:%02d', $minutes, $seconds);
    }

    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        if (!$this->youtube_link) {
            return null;
        }

        // Extract video ID from YouTube URL
        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&\n?#]+)/', $this->youtube_link, $matches);
        
        if (isset($matches[1])) {
            return "https://www.youtube.com/embed/{$matches[1]}";
        }

        return null;
    }

    public function getChordSheetAttribute(): string
    {
        if (!$this->lyrics || !$this->chords) {
            return $this->lyrics ?? '';
        }

        // Simple chord sheet formatting (basic implementation)
        $lines = explode("\n", $this->lyrics);
        $result = [];
        
        foreach ($lines as $line) {
            if (trim($line) === '') {
                $result[] = '';
                continue;
            }
            
            // This is a simplified implementation
            // In a real scenario, you'd want more sophisticated chord placement
            $result[] = $line . ' [' . $this->key . ']';
        }
        
        return implode("\n", $result);
    }

    public function getUsageCountAttribute(): int
    {
        return $this->setlists()->count();
    }

    public function getLastUsedAttribute(): ?string
    {
        $lastSetlist = $this->setlists()
            ->with('churchEvent')
            ->orderBy('date', 'desc')
            ->first();
            
        if ($lastSetlist) {
            return $lastSetlist->date->format('d/m/Y');
        }
        
        return null;
    }
}
