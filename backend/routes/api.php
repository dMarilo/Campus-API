<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\DormController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseBookController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\CourseClassController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);


/*
|--------------------------------------------------------------------------
| Library / Books
|--------------------------------------------------------------------------
*/

Route::get('/books',               [LibraryController::class, 'getAllBooks']);
Route::get('/books/search',        [LibraryController::class, 'searchBooks']);
Route::get('/books/isbn/{isbn}',   [LibraryController::class, 'getBookByIsbn']);
Route::get('/books/available',     [LibraryController::class, 'getAvailableBooks']);

Route::post('/books/load',          [LibraryController::class, 'loadBook']);
Route::delete('/books/delete/{isbn}', [LibraryController::class, 'deleteBook']);


/*
|--------------------------------------------------------------------------
| Dormitories
|--------------------------------------------------------------------------
*/

Route::get('/dorms',               [DormController::class, 'getAllDorms']);
Route::get('/dorms/search',        [DormController::class, 'searchDorms']);
Route::get('/dorms/capacity/{id}', [DormController::class, 'getDormCapacity']);
Route::get('/dorms/rooms/{id}',    [DormController::class, 'getDormRoomCount']);
Route::get('/dorms/{id}',          [DormController::class, 'getDormById']);

Route::post('/dorms/load',         [DormController::class, 'loadDorm']);
Route::put('/dorms/update/{id}',   [DormController::class, 'updateDorm']);
Route::delete('/dorms/delete/{id}', [DormController::class, 'deleteDorm']);


/*
|--------------------------------------------------------------------------
| Dorm Rooms
|--------------------------------------------------------------------------
*/

Route::get('/rooms',                    [RoomController::class, 'getAllRooms']);
Route::get('/rooms/dorm/{dormId}',      [RoomController::class, 'getRoomsByDormId']);
Route::get('/rooms/capacity/{id}',      [RoomController::class, 'getRoomCapacity']);
Route::get('/rooms/search',             [RoomController::class, 'searchRooms']);
Route::get('/rooms/{id}',               [RoomController::class, 'getRoomById']);

Route::post('/rooms/load',               [RoomController::class, 'loadRoom']);
Route::put('/rooms/update/{id}',         [RoomController::class, 'updateRoom']);
Route::delete('/rooms/delete/{id}',      [RoomController::class, 'deleteRoom']);


/*
|--------------------------------------------------------------------------
| Students
|--------------------------------------------------------------------------
*/

Route::get('/students',                 [StudentController::class, 'getAllStudents']);
Route::get('/students/index/{index}',   [StudentController::class, 'getStudentByIndex']);
Route::get('/students/department/{code}', [StudentController::class, 'getStudentsByDepartment']);
Route::get('/students/year/{year}',     [StudentController::class, 'getStudentsByYear']);
Route::get('/students/active',           [StudentController::class, 'getActiveStudents']);
Route::get('/students/inactive',         [StudentController::class, 'getInactiveStudents']);
Route::get('/students/{id}',             [StudentController::class, 'getStudentById']);

Route::post('/students',                [StudentController::class, 'createStudent']);
Route::put('/students/{id}',             [StudentController::class, 'updateStudent']);
Route::delete('/students/{id}',          [StudentController::class, 'deleteStudent']);



Route::get('/classes/{classId}/students',[StudentController::class, 'getStudentsByClass']);


/*
|--------------------------------------------------------------------------
| Borrowings (Library Circulation)
|--------------------------------------------------------------------------
*/

Route::get('/borrowings/student',        [BorrowingController::class, 'studentBorrowings']);
Route::get('/borrowings/active',         [BorrowingController::class, 'allBorrowed']);

Route::post('/borrowings/borrow',        [BorrowingController::class, 'borrow']);
Route::post('/borrowings/return',        [BorrowingController::class, 'return']);


/*
|--------------------------------------------------------------------------
| Professors
|--------------------------------------------------------------------------
*/

Route::get('/professors',                [ProfessorController::class, 'index']);
Route::get('/professors/isbn/{isbn}',    [ProfessorController::class, 'showByIsbn']);
Route::get('/professors/department/{department}', [ProfessorController::class, 'showByDepartment']);
Route::get('/professors/{id}',           [ProfessorController::class, 'showById']);

Route::post('/professors',               [ProfessorController::class, 'store']);
Route::put('/professors/{id}',            [ProfessorController::class, 'update']);
Route::delete('/professors/{id}',         [ProfessorController::class, 'destroy']);


/*
|--------------------------------------------------------------------------
| Courses
|--------------------------------------------------------------------------
*/

Route::get('/courses',                   [CourseController::class, 'index']);
Route::get('/courses/code/{code}',       [CourseController::class, 'showByCode']);
Route::get('/courses/department/{department}', [CourseController::class, 'showByDepartment']);
Route::get('/courses/active',             [CourseController::class, 'active']);
Route::get('/courses/{id}',               [CourseController::class, 'showById']);

Route::post('/courses',                   [CourseController::class, 'store']);
Route::put('/courses/{id}',               [CourseController::class, 'update']);
Route::delete('/courses/{id}',            [CourseController::class, 'destroy']);


/*
|--------------------------------------------------------------------------
| Course ↔ Book (Pivot)
|--------------------------------------------------------------------------
*/

Route::get('/courses/{id}/books',         [CourseBookController::class, 'getByCourse']);


/*
|--------------------------------------------------------------------------
| Campus Buildings
|--------------------------------------------------------------------------
*/

Route::prefix('buildings')->group(function () {
    Route::get('/',          [BuildingController::class, 'index']);
    Route::get('/{code}',    [BuildingController::class, 'showByCode']);

    Route::post('/',         [BuildingController::class, 'store']);
    Route::put('/{id}',      [BuildingController::class, 'update']);
    Route::delete('/{id}',   [BuildingController::class, 'destroy']);
});


/*
|--------------------------------------------------------------------------
| Classrooms
|--------------------------------------------------------------------------
*/

Route::prefix('classrooms')->group(function () {
    Route::get('/',              [ClassroomController::class, 'index']);
    Route::get('/active',        [ClassroomController::class, 'active']);
    Route::get('/inactive',      [ClassroomController::class, 'inactive']);
    Route::get('/code/{code}',   [ClassroomController::class, 'showByCode']);

    Route::post('/',             [ClassroomController::class, 'store']);
    Route::put('/{id}',          [ClassroomController::class, 'update']);
    Route::delete('/{id}',       [ClassroomController::class, 'destroy']);

    // Classroom scanner (professor ISBN + PIN)
    Route::post('/scan',         [ClassroomController::class, 'scan']);
});


/*
|--------------------------------------------------------------------------
| Course Classes
|--------------------------------------------------------------------------
*/

Route::get('/classes/{id}/professors', [CourseClassController::class, 'professors']);
Route::post('/classes/{class}/final-exam', [CourseClassController::class, 'registerFinalExam']);
