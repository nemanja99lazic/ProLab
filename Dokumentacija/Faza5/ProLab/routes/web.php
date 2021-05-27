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
Route::post('/',[App\Http\Controllers\GuestController::class, 'loginPost'])->name('guest.login.post');


Route::get('/register',[App\Http\Controllers\GuestController::class, 'registerGet'])->name('guest.register.get');
Route::post('/register',[App\Http\Controllers\GuestController::class, 'registerPost'])->name('guest.register.post');
Route::get('/register_info',[App\Http\Controllers\GuestController::class, 'registerInfo'])->name('guest.registerinfo');

//Student

Route::get('/student',[App\Http\Controllers\StudentController::class, 'index'])->name('student.index');
Route::get('/student/logout',[App\Http\Controllers\StudentController::class, 'logout'])->name('student.logout');
Route::get('/student/subject/enroll', [App\Http\Controllers\StudentController::class, 'showAllSubjectsList'])->name('student.showAllSubjectsList');
Route::post('/student/subject/enroll', [App\Http\Controllers\StudentController::class, 'sendJoinRequest'])->name('student.sendJoinRequest');

// IZBRISI OVO
Route::get('/student/test', [App\Http\Controllers\StudentController::class, 'test'])->name('student.test');

Route::get('/student/chosen',[App\Http\Controllers\StudentController::class, 'chosen'])->name('student.chosen');
// KOMENTARISI RED ISPOD, OVO SRETEN RADI
Route::get('/student/subject/{code}/index',[App\Http\Controllers\StudentController::class, 'index'])->name('student.subject.index');

Route::get('/student/subject/{code}/lab',[App\Http\Controllers\StudentController::class, 'lab'])->name('student.subject.lab');
Route::get('/student/subject/{code}/lab/{idLab}/join',[App\Http\Controllers\StudentController::class, 'showAppointments'])->name('student.subject.lab.idlab.join.get');
Route::post('/student/subject/{code}/lab/{idLab}/join',[App\Http\Controllers\StudentController::class, 'joinAppointment'])->name('student.subject.lab.idlab.join.post');


//Teacher

Route::get('/teacher',[App\Http\Controllers\TeacherController::class, 'index'])->name('teacher.index');
Route::get('/teacher/logout',[App\Http\Controllers\TeacherController::class, 'logout'])->name('teacher.logout');

Route::get('/teacher/addSubject',[App\Http\Controllers\TeacherController::class, 'addSubjectGet'])->name('teacher.addsubject.get');
Route::post('/teacher/addSubject',[App\Http\Controllers\TeacherController::class, 'addSubjectPost'])->name('teacher.addsubject.post');

Route::get('/teacher/subject/request/list', [App\Http\Controllers\TeacherController::class, 'showRequestsList'])->name('teacher.showRequestsList');
Route::post('/teacher/subject/request/list/accept', [App\Http\Controllers\TeacherController::class, 'acceptRequest'])->name('teacher.acceptRequest');
Route::post('/teacher/subject/request/list/reject', [App\Http\Controllers\TeacherController::class, 'rejectRequest'])->name('teacher.rejectRequest');

Route::get('/teacher/subject/{code}/project', [App\Http\Controllers\TeacherController::class, 'showProjects'])->name('teacher.showProjects');
Route::get('/teacher/subject/{code}/project/define', [App\Http\Controllers\TeacherController::class, 'showProjectForm'])->name('teacher.showProjectForm');
Route::post('/teacher/subject/{code}/project/removeProject', [App\Http\Controllers\TeacherController::class, 'removeProject'])->name('teacher.removeProject');

//Admin

Route::get('/admin',[App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/logout',[App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');
//Route::post('/admin/addUser',[App\Http\Controllers\AdminController::class, 'addUser'])->name('admin.adduser');
//Route::post('/admin/deleteRequest',[App\Http\Controllers\AdminController::class, 'deleteRequest'])->name('admin.deleterequest');
Route::post('/admin/addUser',[App\Http\Controllers\AdminController::class, 'addUser'])->name('admin.adduser');
Route::post('/admin/deleteRequest',[App\Http\Controllers\AdminController::class, 'deleteRequest'])->name('admin.deleterequest');

