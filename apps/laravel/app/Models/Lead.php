<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'type',
        'name',
        'email',
        'phone',
        'company',
        'message',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];
}

