<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'icon',
        'responsible_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(InstitutionalDocument::class);
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }

    public function meetingMinutes(): HasMany
    {
        return $this->hasMany(MeetingMinute::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getDocumentCountAttribute(): int
    {
        return $this->documents()->count();
    }

    public function getActiveAnnouncementsCountAttribute(): int
    {
        return $this->announcements()->where('is_active', true)->count();
    }

    public function getMeetingCountAttribute(): int
    {
        return $this->meetingMinutes()->count();
    }

    protected static function booted()
    {
        static::creating(function ($department) {
            $department->slug = \Illuminate\Support\Str::slug($department->name);
        });
        
        static::updating(function ($department) {
            if ($department->isDirty('name')) {
                $department->slug = \Illuminate\Support\Str::slug($department->name);
            }
        });
    }
}
