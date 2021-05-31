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
Route::post('/student/subject/{code}/lab/{idLab}/leave',[App\Http\Controllers\StudentController::class, 'leaveAppointment'])->name('student.subject.lab.idlab.leave');
Route::get('/student/subject/{code}/lab/{idLab}/swap',[App\Http\Controllers\StudentController::class, 'showPossibleSwaps'])->name('student.subject.code.lab.idlab.swap.get');
Route::post('/student/subject/{code}/lab/{idLab}/swap',[App\Http\Controllers\StudentController::class, 'performSwap'])->name('student.subject.code.lab.idlab.swap.post');
Route::get('/student/subject/{code}/lab/{idLab}/request',[App\Http\Controllers\StudentController::class, 'enterRequest'])->name('student.subject.code.lab.idlab.request.get');
Route::post('/student/subject/{code}/lab/{idLab}/request',[App\Http\Controllers\StudentController::class, 'submitRequest'])->name('student.subject.code.lab.idlab.request.post');

//Teacher

Route::get('/teacher',[App\Http\Controllers\TeacherController::class, 'index'])->name('teacher.index');
Route::get('/teacher/logout',[App\Http\Controllers\TeacherController::class, 'logout'])->name('teacher.logout');
Route::get('/teacher/subject/list',[App\Http\Controllers\HomeController::class, 'getSubjects'])->name('teacher.subject.list');

Route::get('/teacher/addSubject',[App\Http\Controllers\TeacherController::class, 'addSubjectGet'])->name('teacher.addsubject.get');
Route::post('/teacher/addSubject',[App\Http\Controllers\TeacherController::class, 'addSubjectPost'])->name('teacher.addsubject.post');
Route::get  ('/teacher/addSubject/info',[App\Http\Controllers\TeacherController::class, 'addSubjectInfo'])->name('teacher.addsubject.info');

Route::get('/teacher/subject/request/list', [App\Http\Controllers\TeacherController::class, 'showRequestsList'])->name('teacher.showRequestsList');
Route::post('/teacher/subject/request/list/accept', [App\Http\Controllers\TeacherController::class, 'acceptRequest'])->name('teacher.acceptRequest');
Route::post('/teacher/subject/request/list/reject', [App\Http\Controllers\TeacherController::class, 'rejectRequest'])->name('teacher.rejectRequest');

Route::get('/teacher/subject/{code}/project', [App\Http\Controllers\TeacherController::class, 'showProjects'])->name('teacher.showProjects');
Route::get('/teacher/subject/{code}/project/define', [App\Http\Controllers\TeacherController::class, 'showProjectForm'])->name('teacher.showProjectForm');
Route::post('/teacher/subject/{code}/project/removeProject', [App\Http\Controllers\TeacherController::class, 'removeProject'])->name('teacher.removeProject');

//Admin

Route::get('/admin',[App\Http\Controllers\AdminController::class, 'registerRequests'])->name('admin.index');

Route::get('/admin/requests/register',[App\Http\Controllers\AdminController::class, 'registerRequests'])->name('admin.register.requests');
Route::post('/admin/requests/register/addUser',[App\Http\Controllers\AdminController::class, 'addUser'])->name('admin.addUser');
Route::post('/admin/requests/register/delete',[App\Http\Controllers\AdminController::class, 'deleteRegisterRequest'])->name('admin.deleteRequest.register');

Route::get('/admin/requests/newSubjects',[App\Http\Controllers\AdminController::class, 'newSubjectRequests'])->name('admin.newSubject.requests');
Route::post('/admin/requests/newSubjects/addSubject', [App\Http\Controllers\AdminController::class, 'addSubject'])->name('admin.addSubject');
Route::post('/admin/requests/newSubjects/delete', [App\Http\Controllers\AdminController::class, 'deleteSubjectRequest'])->name('admin.deleteRequest.subject');

Route::get('/admin/subjects/list', [App\Http\Controllers\AdminController::class, 'subjectList'])->name('admin.subjects.list');
Route::get('/admin/subjects/{subjectCode}', [App\Http\Controllers\AdminController::class, 'subjectIndex'])->name('admin.subject.index');
Route::post('/admin/subjects/{subjectCode}/delete', [App\Http\Controllers\AdminController::class, 'deleteSubject'])->name('admin.delete.subject');

Route::post('/admin/subjects/{subjectCode}/deleteTeacher/{idT}', [App\Http\Controllers\AdminController::class, 'deleteTeacherFromSubject'])->name('admin.delete.teacher');
Route::post('/admin/subjects/{subjectCode}/deleteStudent/{idSt}', [App\Http\Controllers\AdminController::class, 'deleteStudentFromSubject'])->name('admin.delete.student');

Route::get('/admin/subjects/{subjectCode}/lab/list', [App\Http\Controllers\AdminController::class, 'labExercisesIndex'])->name('admin.subject.lab');
Route::get('/admin/subjects/{subjectCode}/lab', [App\Http\Controllers\AdminController::class, 'labExerciseIndex'])->name('admin.subject.lab.show');
Route::post('/admin/subjects/{subjectCode}/lab/delete', [App\Http\Controllers\AdminController::class, 'labExerciseDelete'])->name('admin.subject.lab.delete');
Route::post('/admin/subjects/{subjectCode}/lab/appointment/{idApp}/delete', [App\Http\Controllers\AdminController::class, 'deleteAppointment'])->name('admin.subject.lab.app.delete');

Route::get('/admin/subjects/{subjectCode}/project', [App\Http\Controllers\AdminController::class, 'projectIndex'])->name('admin.subject.project.index');
Route::post('/admin/subjects/{subjectCode}/project/team/{idTeam}/delete', [App\Http\Controllers\AdminController::class, 'deleteTeam'])->name('admin.subject.team.delete');
Route::post('/admin/subjects/{subjectCode}/project/delete', [App\Http\Controllers\AdminController::class, 'deleteProject'])->name('admin.subject.project.delete');

Route::get('/admin/logout',[App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');
//Route::post('/admin/addUser',[App\Http\Controllers\AdminController::class, 'addUser'])->name('admin.adduser');
//Route::post('/admin/deleteRequest',[App\Http\Controllers\AdminController::class, 'deleteRequest'])->name('admin.deleterequest');

