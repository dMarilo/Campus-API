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


// --- Library Routes ---
Route::get('/books', [LibraryController::class, 'getAllBooks']);
Route::get('/books/search', [LibraryController::class, 'searchBooks']);
Route::get('/books/isbn/{isbn}', [LibraryController::class, 'getBookByIsbn']);
Route::get('/books/available', [LibraryController::class, 'getAvailableBooks']);

Route::post('/books/load', [LibraryController::class, 'loadBook']);

Route::delete('/books/delete/{isbn}', [LibraryController::class, 'deleteBook']);






// routes/api.php

