<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dorm extends Model
{
    protected $fillable = [
        'name',
        'address',
        'total_rooms',
        'total_beds',
        'description',
    ];


    public function getAllDorms()
    {
        return $this->all();
    }

    public function getDormById(int $id)
    {
        return $this->findOrFail($id);
    }

    public function searchDormsByName(string $search)
    {
        return $this->where('name', 'LIKE', '%' . $search . '%')->get();
    }

        public function loadDorm(array $data)
    {
        return $this->create($data);
    }

    public function updateDorm(int $id, array $data)
    {
        $dorm = $this->findOrFail($id);
        $dorm->update($data);
        return $dorm;
    }

    public function deleteDorm(int $id)
    {
        $dorm = $this->findOrFail($id);
        return $dorm->delete();
    }


    public function getDormCapacity(int $id)
    {
        $dorm = $this->findOrFail($id);
        return $dorm->total_beds;
    }

    public function getDormRoomCount(int $id)
    {
        $dorm = $this->findOrFail($id);
        return $dorm->total_rooms;
    }
}
