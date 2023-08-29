<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthController::class, "dashboard"])->name("dashboard");

Route::get('/login', [AuthController::class, "index"])->name("login");
Route::get('/registration', [AuthController::class, "registration"])->name("registration");
Route::post('/post-registration', [AuthController::class, "postRegistration"])->name("registration.post");
Route::post('/post-login', [AuthController::class, "postLogin"])->name("login.post");
Route::get('/dashboard', [AuthController::class, "dashboard"])->name("dashboard");
Route::get('/logout', [AuthController::class, "logout"])->name("logout");
Route::post("/post-add-book", [AuthController::class, "postAddBook"])->name("addbook.post");
// Route::get("/edit-book/{id}", [AuthController::class, "editBook"])->name("bookedit");
Route::post("/post-edit-book/{id}", [AuthController::class, "postEditBook"])->name("editbook.post");
Route::delete("/delete-book/{id}", [AuthController::class, "deleteBook"])->name("deletebook");
Route::get("/admin", [AuthController::class, "admin"])->name("admin");
Route::get("/edit-user/{id}", [AuthController::class, "editUser"])->name("edituser");
Route::post("/post-edit-user/{id}", [AuthController::class, "postEditUser"])->name("edituser.post");
Route::delete("/delete-user/{id}", [AuthController::class, "deleteUser"])->name("deleteuser");
