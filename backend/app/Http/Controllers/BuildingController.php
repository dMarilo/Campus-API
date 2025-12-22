<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    protected Building $building;

    public function __construct(Building $building)
    {
        $this->building = $building;
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->building->getAllBuildings()
        );
    }

    public function showByCode(string $code): JsonResponse
    {
        $building = $this->building->getBuildingByCode($code);

        if (!$building) {
            return response()->json(['message' => 'Building not found'], 404);
        }

        return response()->json($building);
    }

    public function store(Request $request): JsonResponse
    {
        $building = $this->building->createBuilding(
            $request->only([
                'name',
                'code',
                'address',
                'number_of_floors',
                'description',
                'active'
            ])
        );

        return response()->json($building, 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $building = $this->building->updateBuilding(
            $id,
            $request->only([
                'name',
                'code',
                'address',
                'number_of_floors',
                'description',
                'active'
            ])
        );

        if (!$building) {
            return response()->json(['message' => 'Building not found'], 404);
        }

        return response()->json($building);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->building->deleteBuilding($id);

        if (!$deleted) {
            return response()->json(['message' => 'Building not found'], 404);
        }

        return response()->json(['message' => 'Building deactivated']);
    }
}

