<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class Topic extends Model
{
    protected $table = 'topics';
    protected $fillable = [
        'name', 
        'slug'
    ];

    public function posts() {
    return $this->hasMany(Post::class);
    }

}
