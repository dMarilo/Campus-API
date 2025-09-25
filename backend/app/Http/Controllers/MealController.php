<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meal;
use Illuminate\Support\Facades\Validator;

class MealController extends Controller
{
    /**
     * POST /meals
     * Store a new meal entry
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date'  => 'required|date',
            'type'  => 'required|in:breakfast,lunch,dinner',
            'items' => 'required|array|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $meal = new Meal();
        $meal->date = $request->input('date');
        $meal->type = $request->input('type');
        $meal->items = $request->input('items');
        $meal->save();

        return response()->json([
            'message' => 'Meal created successfully',
            'meal'    => $meal,
        ], 201);
    }

    /**
     * GET /meals
     * List all meals grouped by date
     */
    public function index()
    {
        $meals = Meal::all()
            ->groupBy('date')
            ->map(function ($dayMeals) {
                return $dayMeals->mapWithKeys(function ($meal) {
                    return [$meal->type => $meal->items];
                });
            });

        return response()->json($meals);
    }

    /**
     * GET /meals/date/{date}
     * List all meals for a given date
     */
    public function mealsByDate($date)
    {
        $meals = Meal::forDate($date)->get();

        if ($meals->isEmpty()) {
            return response()->json(['message' => 'No meals found for this date'], 404);
        }

        return response()->json([
            'date' => $date,
            'meals' => $meals->mapWithKeys(fn($meal) => [$meal->type => $meal->items]),
        ]);
    }

    /**
     * GET /meals/search/{item}
     * List all dates and meal types where a given item was served
     */
    public function datesByMealItem($item)
    {
        $meals = Meal::withItem($item)->orderBy('date', 'asc')->get();

        if ($meals->isEmpty()) {
            return response()->json(['message' => "No meals found containing '{$item}'"], 404);
        }

        return response()->json($meals->map(function ($meal) {
            return [
                'date' => $meal->date->toDateString(),
                'type' => $meal->type,
                'items' => $meal->items,
            ];
        }));
    }
}
