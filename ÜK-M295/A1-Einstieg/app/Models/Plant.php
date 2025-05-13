<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;

class Plant extends Model
{
    use HasFactory;

    protected $table = 'plants';

    protected $fillable = [
        'name', 
        'slug',
        'description',
        'stock'
    ];

    public function Area() {
        return $this->hasMany(Area::class);
    }
}
