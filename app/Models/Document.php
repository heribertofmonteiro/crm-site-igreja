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

    public function event()
    {
        return $this->belongsTo(Event::class, 'church_event_id');
    }
}
