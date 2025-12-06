<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class msetting extends Model
{
    protected $fillable = [
        'user_id', 'key', 'value'
    ];
}
