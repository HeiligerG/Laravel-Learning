<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function foodItems() : HasMany
    {
        return $this->hasMany(FoodItem::class);
    }

    public static function create(array $data) : Category
    {
        return self::query()->create([
            'name' => $data['name']
        ]);
    }
}
