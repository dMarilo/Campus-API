<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\CourseClassProfessor;

class ClassroomController extends Controller
{
    /**
     * Classroom model instance.
     * Used to manage classroom-related data and operations.
     */
    protected Classroom $classroom;

    /**
     * CourseClassProfessor model instance.
     * Used to resolve teaching assignments for classroom scanning.
     */
    protected CourseClassProfessor $assignment;

    /**
     * Injects required model dependencies into the controller.
     *
     * @param Classroom $classroom
     * @param CourseClassProfessor $assignment
     */
    public function __construct(Classroom $classroom, CourseClassProfessor $assignment)
    {
        $this->classroom = $classroom;
        $this->assignment = $assignment;
    }

    /**
     * Retrieves all classrooms.
     *
     * This endpoint returns all rooms regardless of their active status.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(
            $this->classroom->getAllRooms()
        );
    }

    /**
     * Retrieves a classroom by its unique code.
     *
     * If the classroom does not exist, a 404 response is returned.
     *
     * @param string $code
     * @return JsonResponse
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
     * Retrieves all active classrooms.
     *
     * @return JsonResponse
     */
    public function active(): JsonResponse
    {
        return response()->json(
            $this->classroom->getActiveRooms()
        );
    }

    /**
     * Retrieves all inactive classrooms.
     *
     * @return JsonResponse
     */
    public function inactive(): JsonResponse
    {
        return response()->json(
            $this->classroom->getInactiveRooms()
        );
    }

    /**
     * Creates a new classroom.
     *
     * The provided request data is forwarded to the Classroom model,
     * which handles persistence.
     *
     * @param Request $request
     * @return JsonResponse
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
     * Updates an existing classroom.
     *
     * If the classroom does not exist, a 404 response is returned.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
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
     * Deactivates a classroom instead of permanently deleting it.
     *
     * This logical delete preserves historical data while
     * removing the classroom from active usage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->classroom->deleteRoom($id);

        if (!$deleted) {
            return response()->json(['message' => 'Classroom not found'], 404);
        }

        return response()->json(['message' => 'Classroom deactivated']);
    }

    /**
     * Resolves the course class currently being held in a classroom
     * based on a professor's ISBN and assignment PIN.
     *
     * This endpoint is used by the classroom scanner use-case and:
     *  - Validates the professor's identity
     *  - Validates the teaching assignment via PIN
     *  - Returns the associated course class with course information
     *
     * @param Request $request
     * @return JsonResponse
     */
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
