<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class SessionPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'photo_session_id',
        'type',
        'file_path',
        'original_filename',
        'photo_index',
        'file_size',
    ];

    public function photoSession(): BelongsTo
    {
        return $this->belongsTo(PhotoSession::class);
    }

    public function getUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }
}
