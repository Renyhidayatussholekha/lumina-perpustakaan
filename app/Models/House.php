<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'emblem',
        'motto',
        'color_hex',
        'total_points',
        'member_count',
        'description',
    ];
}
