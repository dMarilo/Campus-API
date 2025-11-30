<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\DormController;
use App\Http\Controllers\RoomController;

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


// Dorms
Route::get('/dorms', [DormController::class, 'getAllDorms']);
Route::get('/dorms/{id}', [DormController::class, 'getDormById']);
//TODO fix this call
Route::get('/dorms/search', [DormController::class, 'searchDorms']);

Route::get('/dorms/capacity/{id}', [DormController::class, 'getDormCapacity']);
Route::get('/dorms/rooms/{id}', [DormController::class, 'getDormRoomCount']);

Route::post('/dorms/load', [DormController::class, 'loadDorm']);

Route::put('/dorms/update/{id}', [DormController::class, 'updateDorm']);

Route::delete('/dorms/delete/{id}', [DormController::class, 'deleteDorm']);


// Rooms
Route::get('/rooms', [RoomController::class, 'getAllRooms']);
Route::get('/rooms/{id}', [RoomController::class, 'getRoomById']);
Route::get('/rooms/dorm/{dormId}', [RoomController::class, 'getRoomsByDormId']);
Route::get('/rooms/capacity/{id}', [RoomController::class, 'getRoomCapacity']);

//TODO fix this call
Route::get('/rooms/search', [RoomController::class, 'searchRooms']);

Route::post('/rooms/load', [RoomController::class, 'loadRoom']);

Route::put('/rooms/update/{id}', [RoomController::class, 'updateRoom']);

Route::delete('/rooms/delete/{id}', [RoomController::class, 'deleteRoom']);


// routes/api.php

