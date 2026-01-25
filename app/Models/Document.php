<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'title',
        'type',
        'file_path',
        'member_id',
        'church_event_id',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function churchEvent()
    {
        return $this->belongsTo(ChurchEvent::class);
    }
}
