<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Area;

class Plant extends Model
{
    protected $table = 'plants';
    protected $fillable = [
        'name', 
        'slug',
        'description',
        'stock'
    ];

    public function Area() {
        return $this->belongsTo(Area::class);
    }
}
