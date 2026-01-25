<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Missionary extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'country',
        'region',
        'start_date',
        'end_date',
        'status',
        'bio',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function projects(): HasMany
    {
        return $this->hasMany(MissionProject::class);
    }

    public function supports(): HasMany
    {
        return $this->hasMany(MissionSupport::class);
    }
}
