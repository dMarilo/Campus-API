<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $fillable = [
        'name',
        'code',
        'address',
        'number_of_floors',
        'description',
        'active',
    ];

    public function getAllBuildings()
    {
        return self::where('active', true)->get();
    }

    public function getBuildingByCode(string $code)
    {
        return self::where('code', $code)
            ->where('active', true)
            ->first();
    }

    public function createBuilding(array $data)
    {
        return self::create($data);
    }

    public function updateBuilding(int $id, array $data)
    {
        $building = self::find($id);

        if (!$building) {
            return null;
        }

        $building->update($data);
        return $building;
    }

    public function deleteBuilding(int $id): bool
    {
        $building = self::find($id);

        if (!$building) {
            return false;
        }

        // Soft delete behavior via active flag
        $building->active = false;
        $building->save();

        return true;
    }
}
