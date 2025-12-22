<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    /**
     * Mass-assignable attributes for the Classroom model.
     * Represents the physical and administrative properties of a classroom.
     */
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


    /**
     * Retrieves all classrooms from the database,
     * regardless of their active status.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllRooms()
    {
        return self::all();
    }

    /**
     * Retrieves a classroom by its unique code.
     *
     * @param string $code
     * @return Classroom|null
     */
    public function getRoomByCode(string $code)
    {
        return self::where('code', $code)->first();
    }

    /**
     * Retrieves all classrooms that are currently active.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveRooms()
    {
        return self::where('active', true)->get();
    }

    /**
     * Retrieves all classrooms that are currently inactive.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getInactiveRooms()
    {
        return self::where('active', false)->get();
    }

    /**
     * Creates and stores a new classroom record in the database.
     *
     * @param array $data
     * @return Classroom
     */
    public function createRoom(array $data)
    {
        return self::create($data);
    }

    /**
     * Updates an existing classroom with new data.
     * Returns null if the classroom does not exist.
     *
     * @param int $id
     * @param array $data
     * @return Classroom|null
     */
    public function updateRoom(int $id, array $data)
    {
        $room = self::find($id);

        if (!$room) {
            return null;
        }

        $room->update($data);
        return $room;
    }

    /**
     * Deactivates a classroom instead of permanently deleting it.
     * This preserves historical usage and avoids breaking references.
     *
     * @param int $id
     * @return bool
     */
    public function deleteRoom(int $id): bool
    {
        $room = self::find($id);

        if (!$room) {
            return false;
        }

        $room->active = false;
        $room->save();

        return true;
    }
}
