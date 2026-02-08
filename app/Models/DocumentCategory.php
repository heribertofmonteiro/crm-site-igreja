<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DocumentCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function documents(): HasMany
    {
        return $this->hasMany(InstitutionalDocument::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getDocumentCountAttribute(): int
    {
        return $this->documents()->count();
    }

    public function getPublicDocumentCountAttribute(): int
    {
        return $this->documents()->where('is_public', true)->count();
    }

    protected static function booted()
    {
        static::creating(function ($category) {
            $category->slug = \Illuminate\Support\Str::slug($category->name);
        });
        
        static::updating(function ($category) {
            if ($category->isDirty('name')) {
                $category->slug = \Illuminate\Support\Str::slug($category->name);
            }
        });
    }
}
