<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    // Get all professors
    public function index()
    {
        return response()->json(Professor::all());
    }

    // Search professors by name
    public function search(Request $request)
    {
        $name = $request->query('name');

        $professors = Professor::where('first_name', 'like', "%{$name}%")
            ->orWhere('last_name', 'like', "%{$name}%")
            ->get();

        return response()->json($professors);
    }

    // Add new professor
    public function store(Request $request)
    {
        $validated = $request->validate([
            'professor_code' => 'required|string|unique:professors,professor_code',
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'email'          => 'required|email|unique:professors,email',
            'phone'          => 'nullable|string|max:20',
            'department'     => 'required|string|max:255',
            'faculty'        => 'required|string|max:255',
            'office'         => 'nullable|string|max:100',
            'bio'            => 'nullable|string',
        ]);

        $professor = Professor::create($validated);

        return response()->json([
            'message'   => 'Professor added successfully',
            'professor' => $professor,
        ], 201);
    }

}
