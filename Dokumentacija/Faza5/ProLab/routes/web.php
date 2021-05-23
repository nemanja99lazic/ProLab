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
Route::get("/testAdmin", [\App\Http\Controllers\HomeController::class, "testAdmin"])->name("testadmin");

//Guest

Route::get('/',[App\Http\Controllers\GuestController::class, 'loginGet'])->name('guest.login.get');  //DEFAULT ruta
Route::post('/',[App\Http\Controllers\GuestController::class, 'loginPost'])->name('guest.login.post');


Route::get('/register',[App\Http\Controllers\GuestController::class, 'registerGet'])->name('guest.register.get');
Route::post('/register',[App\Http\Controllers\GuestController::class, 'registerPost'])->name('guest.register.post');
Route::get('/register_info',[App\Http\Controllers\GuestController::class, 'registerInfo'])->name('guest.registerinfo');

//Student

Route::get('/student',[App\Http\Controllers\StudentController::class, 'index'])->name('student.index');
Route::get('/student/logout',[App\Http\Controllers\StudentController::class, 'logout'])->name('student.logout');

//Teacher

Route::get('/teacher',[App\Http\Controllers\TeacherController::class, 'index'])->name('teacher.index');
Route::get('/teacher/logout',[App\Http\Controllers\TeacherController::class, 'logout'])->name('teacher.logout');
Route::get('/teacher/subject/list',[App\Http\Controllers\HomeController::class, 'getSubjects'])->name('teacher.subject.list');

//Admin

Route::get('/admin',[App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/logout',[App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');
//Route::post('/admin/addUser',[App\Http\Controllers\AdminController::class, 'addUser'])->name('admin.adduser');
//Route::post('/admin/deleteRequest',[App\Http\Controllers\AdminController::class, 'deleteRequest'])->name('admin.deleterequest');
Route::post('/admin/addUser',[App\Http\Controllers\AdminController::class, 'addUser'])->name('admin.adduser');
Route::post('/admin/deleteRequest',[App\Http\Controllers\AdminController::class, 'deleteRequest'])->name('admin.deleterequest');

