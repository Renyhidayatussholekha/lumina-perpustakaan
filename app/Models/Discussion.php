<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Discussion extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'user_name',
        'user_avatar',
        'user_house',
        'comment',
        'is_ai_prompt',
        'likes_count',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
