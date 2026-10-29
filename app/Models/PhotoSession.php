<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PhotoSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'session_code',
        'slug',
        'user_email',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(SessionPhoto::class)->orderBy('photo_index');
    }

    public function stripPhoto()
    {
        return $this->hasOne(SessionPhoto::class)->where('type', 'strip');
    }

    public function singlePhotos()
    {
        return $this->hasMany(SessionPhoto::class)->where('type', 'single')->orderBy('photo_index');
    }
}
