<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'author',
        'category',
        'grade_level',
        'cover_url',
        'banner_url',
        'synopsis',
        'ai_summary_1',
        'ai_summary_2',
        'ai_summary_3',
        'reading_time_minutes',
        'rating',
        'total_readers',
        'audio_text',
        'content',
        'is_featured',
        'trending_label',
    ];

    public function characters(): HasMany
    {
        return $this->hasMany(BookCharacter::class);
    }

    public function discussions(): HasMany
    {
        return $this->hasMany(Discussion::class)->orderBy('created_at', 'desc');
    }
}
