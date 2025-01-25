<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
USE Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'community_id'];

    public function foodItems() : HasMany
    {
        return $this->hasMany(FoodItem::class);
    }

    public function community() : BelongsTo
    {
        return $this->belongsTo(Community::class);
    }
}
