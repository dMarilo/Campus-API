<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\MealController;

//---

# Authentication Routes
// Register a new user
Route::post('/register', [AuthController::class, 'register']);

// Login a user
Route::post('/login', [AuthController::class, 'login']);


//---

# Library / Books Routes
// Get all books
Route::get('/books', [LibraryController::class, 'books']);

// Search for books by title, author, or ISBN
Route::get('/books/search', [LibraryController::class, 'search']);

// Add a new book to a library
Route::post('/Storebooks', [LibraryController::class, 'store']);

Route::post('/sync-titles', [LibraryController::class, 'syncTitles']);





Route::get('/meals', [MealController::class, 'index']);                // all meals grouped by date
Route::post('/meals', [MealController::class, 'store']);             // add meal
Route::get('/meals/date/{date}', [MealController::class, 'mealsByDate']);
Route::get('/meals/search/{item}', [MealController::class, 'datesByMealItem']);


