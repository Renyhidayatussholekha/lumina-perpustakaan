<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'icon',
        'target_count',
        'current_count',
        'xp_reward',
        'category',
        'is_completed',
    ];
}
