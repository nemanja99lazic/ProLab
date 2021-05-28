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

Route::get('/teacher/addSubject',[App\Http\Controllers\TeacherController::class, 'addSubjectGet'])->name('teacher.addsubject.get');
Route::post('/teacher/addSubject',[App\Http\Controllers\TeacherController::class, 'addSubjectPost'])->name('teacher.addsubject.post');
Route::get  ('/teacher/addSubject/info',[App\Http\Controllers\TeacherController::class, 'addSubjectInfo'])->name('teacher.addsubject.info');

//Admin

Route::get('/admin',[App\Http\Controllers\AdminController::class, 'registerRequests'])->name('admin.index');

Route::get('/admin/requests/register',[App\Http\Controllers\AdminController::class, 'registerRequests'])->name('admin.register.requests');
Route::post('/admin/requests/register/addUser',[App\Http\Controllers\AdminController::class, 'addUser'])->name('admin.addUser');
Route::post('/admin/requests/register/delete',[App\Http\Controllers\AdminController::class, 'deleteRegisterRequest'])->name('admin.deleteRequest.register');

Route::get('/admin/requests/newSubjects',[App\Http\Controllers\AdminController::class, 'newSubjectRequests'])->name('admin.newSubject.requests');
Route::post('/admin/requests/newSubjects/addSubject', [\App\Http\Controllers\AdminController::class, 'addSubject'])->name('admin.addSubject');
Route::post('/admin/requests/newSubjects/delete', [\App\Http\Controllers\AdminController::class, 'deleteSubjectRequest'])->name('admin.deleteRequest.subject');

Route::get('/admin/subjects/list', [\App\Http\Controllers\AdminController::class, 'subjectList'])->name('admin.subjects.list');

Route::get('/admin/logout',[App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');
//Route::post('/admin/addUser',[App\Http\Controllers\AdminController::class, 'addUser'])->name('admin.adduser');
//Route::post('/admin/deleteRequest',[App\Http\Controllers\AdminController::class, 'deleteRequest'])->name('admin.deleterequest');

