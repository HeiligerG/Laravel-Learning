<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Plant;

class Area extends Model
{
    use HasFactory;

    protected $table = 'areas';
    
    protected $fillable = [
        'name',
        'slug',
        'description',
        'address',
        'city',
        'zip',
    ];

    public function Plant() {
        return $this->hasOne(Plant::class);
    }
}
