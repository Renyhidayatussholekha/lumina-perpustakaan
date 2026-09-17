<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookCharacter extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'name',
        'role_title',
        'avatar',
        'greeting_message',
        'system_persona',
        'sample_questions',
    ];

    protected $casts = [
        'sample_questions' => 'array',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
