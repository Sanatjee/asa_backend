<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramKB extends Model
{
    protected $fillable = [
        'title',
        'category',
        'content',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}