<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    // ------------------------------------------------
    // GET ALL ROOMS
    // ------------------------------------------------
    public function getAllRooms()
    {
        $rooms = (new Room)->getAllRooms();

        return response()->json([
            'success' => true,
            'data' => $rooms
        ]);
    }

    // ------------------------------------------------
    // GET ROOM BY ID
    // ------------------------------------------------
    public function getRoomById($id)
    {
        $room = (new Room)->getRoomById($id);

        return response()->json([
            'success' => true,
            'data' => $room
        ]);
    }

    // ------------------------------------------------
    // GET ROOMS BY DORM ID
    // ------------------------------------------------
    public function getRoomsByDormId($dormId)
    {
        $rooms = (new Room)->getRoomsByDormId($dormId);

        return response()->json([
            'success' => true,
            'data' => $rooms
        ]);
    }

    // ------------------------------------------------
    // SEARCH ROOMS BY ROOM NUMBER
    // ------------------------------------------------
    public function searchRooms(Request $request)
    {
        $request->validate([
            'number' => 'required|string|min:1',
        ]);

        $term = $request->query('number');

        $rooms = (new Room)->searchRoomsByNumber($term);

        return response()->json([
            'success' => true,
            'data' => $rooms
        ]);
    }

    // ------------------------------------------------
    // CREATE NEW ROOM
    // ------------------------------------------------
    public function loadRoom(Request $request)
    {
        $validated = $request->validate([
            'dorm_id' => 'required|integer|exists:dorms,id',
            'room_number' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'floor' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        $room = (new Room)->loadRoom($validated);

        return response()->json([
            'success' => true,
            'message' => 'Room successfully added.',
            'data' => $room
        ], 201);
    }

    // ------------------------------------------------
    // UPDATE ROOM
    // ------------------------------------------------
    public function updateRoom(Request $request, $id)
    {
        $validated = $request->validate([
            'dorm_id' => 'nullable|integer|exists:dorms,id',
            'room_number' => 'nullable|string',
            'capacity' => 'nullable|integer|min:1',
            'floor' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        $room = (new Room)->updateRoom($id, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Room updated successfully.',
            'data' => $room
        ]);
    }

    // ------------------------------------------------
    // DELETE ROOM
    // ------------------------------------------------
    public function deleteRoom($id)
    {
        (new Room)->deleteRoom($id);

        return response()->json([
            'success' => true,
            'message' => 'Room deleted successfully.'
        ]);
    }

    // ------------------------------------------------
    // GET ROOM CAPACITY
    // ------------------------------------------------
    public function getRoomCapacity($id)
    {
        $capacity = (new Room)->getRoomCapacity($id);

        return response()->json([
            'success' => true,
            'capacity' => $capacity
        ]);
    }
}
