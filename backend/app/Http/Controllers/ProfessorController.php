<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    protected Professor $professor;

    public function __construct(Professor $professor)
    {
        $this->professor = $professor;
    }

    public function index()
    {
        return response()->json(
            $this->professor->findAll()
        );
    }

    public function showById(int $id)
    {
        return response()->json(
            $this->professor->findById($id)
        );
    }

    public function showByIsbn(string $isbn)
    {
        return response()->json(
            $this->professor->findByIsbn($isbn)
        );
    }

    public function showByDepartment(string $department)
    {
        return response()->json(
            $this->professor->findByDepartment($department)
        );
    }

    public function store(Request $request)
    {
        $professor = $this->professor->createProfessor(
            $request->only($this->professor->getFillable())
        );

        return response()->json($professor, 201);
    }

    public function update(Request $request, int $id)
    {
        $professor = $this->professor->updateProfessor(
            $id,
            $request->only($this->professor->getFillable())
        );

        return response()->json($professor);
    }

    public function destroy(int $id)
    {
        $this->professor->deleteProfessor($id);

        return response()->json([
            'message' => 'Professor deleted successfully'
        ]);
    }
}
