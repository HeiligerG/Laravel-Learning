<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class Author extends Model
{
    protected $table = 'authors';
    protected $fillable = ['name'];

    public function posts() {
        return $this->hasMany(Post::class);
        }
}
