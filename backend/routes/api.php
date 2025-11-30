<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ClassroomController;

//---

# Authentication Routes
// Register a new user
Route::post('/register', [AuthController::class, 'register']);

// Login a user
Route::post('/login', [AuthController::class, 'login']);


//---




// routes/api.php

