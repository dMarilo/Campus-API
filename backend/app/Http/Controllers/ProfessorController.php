<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    /**
     * Professor model instance.
     * Used to manage professor-related data and operations.
     */
    protected Professor $professor;

    /**
     * Injects the Professor model into the controller.
     *
     * @param Professor $professor
     */
    public function __construct(Professor $professor)
    {
        $this->professor = $professor;
    }

    /**
     * Retrieves all professors.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(
            $this->professor->findAll()
        );
    }

    /**
     * Retrieves a professor by their unique identifier.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showById(int $id)
    {
        return response()->json(
            $this->professor->findById($id)
        );
    }

    /**
     * Retrieves a professor by their ISBN identifier.
     *
     * @param string $isbn
     * @return \Illuminate\Http\JsonResponse
     */
    public function showByIsbn(string $isbn)
    {
        return response()->json(
            $this->professor->findByIsbn($isbn)
        );
    }

    /**
     * Retrieves all professors belonging to a specific department.
     *
     * @param string $department
     * @return \Illuminate\Http\JsonResponse
     */
    public function showByDepartment(string $department)
    {
        return response()->json(
            $this->professor->findByDepartment($department)
        );
    }

    /**
     * Creates a new professor record.
     *
     * The request data is filtered using the model's fillable attributes
     * to ensure safe mass assignment.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $professor = $this->professor->createProfessor(
            $request->only($this->professor->getFillable())
        );

        return response()->json($professor, 201);
    }

    /**
     * Updates an existing professor record.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $professor = $this->professor->updateProfessor(
            $id,
            $request->only($this->professor->getFillable())
        );

        return response()->json($professor);
    }

    /**
     * Deletes a professor record from the database.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $this->professor->deleteProfessor($id);

        return response()->json([
            'message' => 'Professor deleted successfully'
        ]);
    }
}
