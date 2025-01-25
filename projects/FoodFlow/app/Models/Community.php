<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Community extends Model {
    protected $fillable = ['name', 'code', 'password'];

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function foodItems() {
        return $this->hasMany(FoodItem::class);
    }
}
