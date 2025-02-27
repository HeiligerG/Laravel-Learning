<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FoodItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'category_id',
        'location_id',
        'expiration_date',
        'quantity',
        'community_id'
    ];

    protected $casts = [
        'expiration_date' => 'date'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
    
    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

}
