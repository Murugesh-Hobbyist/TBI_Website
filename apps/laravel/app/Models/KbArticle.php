<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KbArticle extends Model
{
    protected $table = 'kb_articles';

    protected $fillable = [
        'title',
        'slug',
        'body',
        'tags',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];
}

