<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = [
        'building_id',
        'name',
        'code',
        'floor',
        'capacity',
        'type',
        'description',
        'active',
    ];

    /*
     |--------------------------------------------------------------------------
     | Query methods
     |--------------------------------------------------------------------------
     */

    public function getAllRooms()
    {
        return self::all();
    }

    public function getRoomByCode(string $code)
    {
        return self::where('code', $code)->first();
    }

    public function getActiveRooms()
    {
        return self::where('active', true)->get();
    }

    public function getInactiveRooms()
    {
        return self::where('active', false)->get();
    }

    public function createRoom(array $data)
    {
        return self::create($data);
    }

    public function updateRoom(int $id, array $data)
    {
        $room = self::find($id);

        if (!$room) {
            return null;
        }

        $room->update($data);
        return $room;
    }

    public function deleteRoom(int $id): bool
    {
        $room = self::find($id);

        if (!$room) {
            return false;
        }

        // logical delete
        $room->active = false;
        $room->save();

        return true;
    }
}


