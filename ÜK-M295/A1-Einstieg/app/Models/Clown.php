<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clown extends Model
{
    use HasFactory;

    protected $table = 'clowns';

    protected $fillable = [
        'name',
        'email',
        'description',
        'rating',
        'status'
    ];
}
