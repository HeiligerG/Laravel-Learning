<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'slug',
        'year',
        'pages',
    ];

    protected $casts = [
        'year' => 'integer',
        'pages' => 'integer',
    ];
}