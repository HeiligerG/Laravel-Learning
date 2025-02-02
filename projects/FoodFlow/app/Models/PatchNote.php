<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PatchNote extends Model
{
    protected $fillable = ['version', 'description', 'release_date'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_patch_notes')
            ->withPivot('seen')
            ->withTimestamps();
    }
}
