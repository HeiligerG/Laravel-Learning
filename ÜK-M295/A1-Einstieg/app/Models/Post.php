<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Topic;
use App\Models\Author;

class Post extends Model
{
    protected $table = 'posts';
    protected $fillable = [
        'title', 
        'content',
    ];

    public function topic() {
    return $this->belongsTo(Topic::class);
    }

    public function author() {
        return $this->belongsTo(Author::class);
    }

}
