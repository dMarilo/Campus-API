<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dorm;

class DormController extends Controller
{
    // ---------------------------------------------
    // GET ALL
    // ---------------------------------------------
    public function getAllDorms()
    {
        $dorms = (new Dorm)->getAllDorms();

        return response()->json([
            'success' => true,
            'data' => $dorms
        ]);
    }

    // ---------------------------------------------
    // GET ONE
    // ---------------------------------------------
    public function getDormById($id)
    {
        $dorm = (new Dorm)->getDormById($id);

        return response()->json([
            'success' => true,
            'data' => $dorm
        ]);
    }

    // ---------------------------------------------
    // SEARCH BY NAME
    // ---------------------------------------------
    public function searchDorms(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:1',
        ]);

        $searchTerm = $request->query('name');

        $dorms = (new Dorm)->searchDormsByName($searchTerm);

        return response()->json([
            'success' => true,
            'data' => $dorms
        ]);
    }


    // ---------------------------------------------
    // CREATE NEW DORM
    // ---------------------------------------------
    public function loadDorm(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'address' => 'nullable|string',
            'total_rooms' => 'required|integer|min:0',
            'total_beds' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $dorm = (new Dorm)->loadDorm($validated);

        return response()->json([
            'success' => true,
            'message' => 'Dorm successfully added.',
            'data' => $dorm
        ], 201);
    }

    // ---------------------------------------------
    // UPDATE DORM
    // ---------------------------------------------
    public function updateDorm(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'nullable|string',
            'address' => 'nullable|string',
            'total_rooms' => 'nullable|integer|min:0',
            'total_beds' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $dorm = (new Dorm)->updateDorm($id, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Dorm updated successfully.',
            'data' => $dorm
        ]);
    }

    // ---------------------------------------------
    // DELETE DORM
    // ---------------------------------------------
    public function deleteDorm($id)
    {
        (new Dorm)->deleteDorm($id);

        return response()->json([
            'success' => true,
            'message' => 'Dorm deleted successfully.'
        ]);
    }

    // ---------------------------------------------
    // EXTRA INFO: CAPACITY
    // ---------------------------------------------
    public function getDormCapacity($id)
    {
        $capacity = (new Dorm)->getDormCapacity($id);

        return response()->json([
            'success' => true,
            'capacity' => $capacity
        ]);
    }

    // ---------------------------------------------
    // EXTRA INFO: ROOM COUNT
    // ---------------------------------------------
    public function getDormRoomCount($id)
    {
        $rooms = (new Dorm)->getDormRoomCount($id);

        return response()->json([
            'success' => true,
            'rooms' => $rooms
        ]);
    }
}
