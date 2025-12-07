<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\DormController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseBookController;

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





//students
Route::get('/students', [StudentController::class, 'getAllStudents']);

Route::get('/students/index/{index}', [StudentController::class, 'getStudentByIndex']);
Route::get('/students/department/{code}', [StudentController::class, 'getStudentsByDepartment']);
// Year of study
Route::get('/students/year/{year}', [StudentController::class, 'getStudentsByYear']);
// Active / Inactive
Route::get('/students/active', [StudentController::class, 'getActiveStudents']);
Route::get('/students/inactive', [StudentController::class, 'getInactiveStudents']);


Route::get('/students/{id}', [StudentController::class, 'getStudentById']);

Route::post('/students', [StudentController::class, 'createStudent']);
Route::put('/students/{id}', [StudentController::class, 'updateStudent']);
Route::delete('/students/{id}', [StudentController::class, 'deleteStudent']);






// --- Borowing ---
Route::get('borrowings/student', [BorrowingController::class, 'studentBorrowings']);
Route::get('/borrowings/active', [BorrowingController::class, 'allBorrowed']);


Route::post('/borrowings/borrow', [BorrowingController::class, 'borrow']);
Route::post('/borrowings/return', [BorrowingController::class, 'return']);



// --- Professors ---
Route::get('/professors', [ProfessorController::class, 'index']);
Route::get('/professors/isbn/{isbn}', [ProfessorController::class, 'showByIsbn']);
Route::get('/professors/department/{department}', [ProfessorController::class, 'showByDepartment']);
Route::get('/professors/{id}', [ProfessorController::class, 'showById']);

Route::post('/professors', [ProfessorController::class, 'store']);
Route::put('/professors/{id}', [ProfessorController::class, 'update']);
Route::delete('/professors/{id}', [ProfessorController::class, 'destroy']);




// --- Courses ---

// READ
Route::get('/courses', [CourseController::class, 'index']);
Route::get('/courses/code/{code}', [CourseController::class, 'showByCode']);
Route::get('/courses/department/{department}', [CourseController::class, 'showByDepartment']);
Route::get('/courses/active', [CourseController::class, 'active']);
Route::get('/courses/{id}', [CourseController::class, 'showById']);

// WRITE
Route::post('/courses', [CourseController::class, 'store']);
Route::put('/courses/{id}', [CourseController::class, 'update']);
Route::delete('/courses/{id}', [CourseController::class, 'destroy']);


// routes/api.php



Route::get('/courses/{id}/books', [CourseBookController::class, 'getByCourse']);
