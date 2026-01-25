<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SocialProject extends Model
{
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
        'budget',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'budget' => 'decimal:2',
    ];

    public function assistances(): HasMany
    {
        return $this->hasMany(SocialAssistance::class);
    }

    public function volunteers(): HasMany
    {
        return $this->hasMany(SocialVolunteer::class);
    }
}
