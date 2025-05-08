<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Plant;

class Area extends Model
{
    protected $table = 'areas';
    protected $fillable = [
        'name',
        'slug',
        'description',
        'address',
        'city',
        'zip'
    ];

    public function Plant() {
        return $this->belongsTo(Plant::class);
    }
}
