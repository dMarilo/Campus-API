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

    public function getAllRooms()
    {
        return $this->all();
    }

    public function getRoomById(int $id)
    {
        return $this->findOrFail($id);
    }

    public function getRoomsByDormId(int $dormId)
    {
        return $this->where('dorm_id', $dormId)->get();
    }

    public function searchRoomsByNumber(string $query)
    {
        return $this->where('room_number', 'LIKE', '%' . $query . '%')->get();
    }

    public function loadRoom(array $data)
    {
        return $this->create($data);
    }

    public function updateRoom(int $id, array $data)
    {
        $room = $this->findOrFail($id);
        $room->update($data);
        return $room;
    }

    public function deleteRoom(int $id)
    {
        $room = $this->findOrFail($id);
        return $room->delete();
    }

    public function getRoomCapacity(int $id)
    {
        return $this->findOrFail($id)->capacity;
    }




}
