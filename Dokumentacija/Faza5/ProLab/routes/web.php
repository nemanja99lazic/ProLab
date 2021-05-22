<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

// Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

//Funkcionalnosti :
// Login, Logout, Register, Index
//


//Guest



Route::get('/',[App\Http\Controllers\GuestController::class, 'loginGet'])->name('guest.login.get');  //DEFAULT ruta
Route::post('/login',[App\Http\Controllers\GuestController::class, 'loginPost'])->name('guest.login.post');


Route::get('/register',[App\Http\Controllers\GuestController::class, 'registerGet'])->name('guest.register.get');
Route::post('/register',[App\Http\Controllers\GuestController::class, 'registerPost'])->name('guest.register.post');

//Student

Route::get('/student',[App\Http\Controllers\StudentController::class, 'index'])->name('student.index');
Route::get('/student/logout',[App\Http\Controllers\StudentController::class, 'logout'])->name('student.logout');
Route::get('/student/chosen',[App\Http\Controllers\StudentController::class, 'chosen'])->name('student.chosen');
//Teacher

Route::get('/teacher',[App\Http\Controllers\TeacherController::class, 'index'])->name('teacher.index');
Route::get('/teacher/logout',[App\Http\Controllers\TeacherController::class, 'logout'])->name('teacher.logout');

//Admin

Route::get('/admin',[App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/logout',[App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');
