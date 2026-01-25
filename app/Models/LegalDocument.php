<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LegalDocument extends Model
{
    protected $fillable = [
        'title',
        'description',
        'document_type',
        'file_path',
        'expiration_date',
        'status',
        'created_by',
    ];

    protected $casts = [
        'expiration_date' => 'date',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
