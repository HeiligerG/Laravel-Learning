<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Community extends Model {
    protected $fillable = ['name', 'code', 'password'];

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps()
            ->withPivot('is_active');
    }

    public function foodItems()
    {
        return $this->hasMany(FoodItem::class);
    }
}
