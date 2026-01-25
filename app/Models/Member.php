<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'birth_date',
        'baptism_date',
        'marital_status',
        'last_birthday_email_sent',
        'last_followup_email_sent',
    ];

    protected $casts = [
        'email' => 'encrypted',
        'phone' => 'encrypted',
        'birth_date' => 'date',
        'baptism_date' => 'date',
        'last_birthday_email_sent' => 'date',
        'last_followup_email_sent' => 'date',
    ];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function deviceTokens()
    {
        return $this->morphMany(DeviceToken::class, 'tokenable');
    }
}
