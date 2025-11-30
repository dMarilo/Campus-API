<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
        protected $fillable = [
        'dorm_id',
        'room_number',
        'capacity',
        'floor',
        'description',
    ];

    // A room belongs to one dorm
    public function dorm()
    {
        return $this->belongsTo(Dorm::class);
    }
}
