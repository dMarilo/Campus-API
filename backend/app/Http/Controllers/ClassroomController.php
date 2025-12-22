<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\CourseClassProfessor;

class ClassroomController extends Controller
{
    protected Classroom $classroom;
    protected CourseClassProfessor $assignment;

    public function __construct(Classroom $classroom, CourseClassProfessor $assignment)
    {
        $this->classroom = $classroom;
        $this->assignment = $assignment;
    }

    /**
     * Get all rooms
     */
    public function index(): JsonResponse
    {
        return response()->json(
            $this->classroom->getAllRooms()
        );
    }

    /**
     * Get room by code
     */
    public function showByCode(string $code): JsonResponse
    {
        $room = $this->classroom->getRoomByCode($code);

        if (!$room) {
            return response()->json(['message' => 'Classroom not found'], 404);
        }

        return response()->json($room);
    }

    /**
     * Get active rooms
     */
    public function active(): JsonResponse
    {
        return response()->json(
            $this->classroom->getActiveRooms()
        );
    }

    /**
     * Get inactive rooms
     */
    public function inactive(): JsonResponse
    {
        return response()->json(
            $this->classroom->getInactiveRooms()
        );
    }

    /**
     * Create room
     */
    public function store(Request $request): JsonResponse
    {
        $room = $this->classroom->createRoom(
            $request->only([
                'building_id',
                'name',
                'code',
                'floor',
                'capacity',
                'type',
                'description',
                'active',
            ])
        );

        return response()->json($room, 201);
    }

    /**
     * Update room
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $room = $this->classroom->updateRoom(
            $id,
            $request->only([
                'building_id',
                'name',
                'code',
                'floor',
                'capacity',
                'type',
                'description',
                'active',
            ])
        );

        if (!$room) {
            return response()->json(['message' => 'Classroom not found'], 404);
        }

        return response()->json($room);
    }

    /**
     * Delete room (deactivate)
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->classroom->deleteRoom($id);

        if (!$deleted) {
            return response()->json(['message' => 'Classroom not found'], 404);
        }

        return response()->json(['message' => 'Classroom deactivated']);
    }

    public function scan(Request $request): JsonResponse
    {
        $request->validate([
            'isbn' => 'required|string',
            'pin'  => 'required|string',
        ]);

        $class = $this->assignment->resolveClassByIsbnAndPin(
            $request->isbn,
            $request->pin
        );

        return response()->json($class);
    }
}

