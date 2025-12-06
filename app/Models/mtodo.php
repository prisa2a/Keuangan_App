<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mtodo extends Model
{
    protected $fillable = [
        'user_id', 'title', 'description',
        'due_date', 'is_done', 'priority'
    ];

    protected $casts = [
        'is_done' => 'boolean',
        'due_date' => 'date'
    ];
}
