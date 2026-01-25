<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PastoralCouncil extends Model
{
    protected $fillable = [
        'name',
        'description',
        'vision',
        'doctrine_statement',
        'members',
    ];

    protected $casts = [
        'members' => 'array',
    ];

    public function pastoralNotes(): HasMany
    {
        return $this->hasMany(PastoralNote::class, 'council_id');
    }
}
