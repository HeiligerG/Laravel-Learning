<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Topic;

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

}
