<?php

// app/Http/Controllers/ClassController.php
namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    // Get all classes
    public function index()
    {
        return response()->json(ClassModel::with('professor')->get());
    }

    // Search by name
    public function search(Request $request)
    {
        $name = $request->query('name');
        $classes = ClassModel::where('name', 'like', "%{$name}%")->with('professor')->get();
        return response()->json($classes);
    }

    // Insert new class
    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_code'   => 'required|string|unique:classes,class_code',
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'professor_id' => 'nullable|exists:professors,id',
            'year'         => 'required|integer|min:1',
            'semester'     => 'required|integer|min:1|max:2',
        ]);

        $class = ClassModel::create($validated);

        return response()->json([
            'message' => 'Class added successfully',
            'class'   => $class,
        ], 201);
    }
}

