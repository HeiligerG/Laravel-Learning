<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'firstname',
        'lastname',
        'note',
        'date',
        'nights',
        'room_temperature',
    ];

    protected $casts = [
        'date' => 'date',
        'room_temperature' => 'decimal:1',
    ];
}
