<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuestController;

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


//Guest

Route::get('/',[GuestController::class, 'loginGet'])->name('guest.login.get');  //DEFAULT ruta
Route::post('/',[GuestController::class, 'loginPost'])->name('guest.login.post');


Route::get('/register',[GuestController::class, 'registerGet'])->name('guest.register.get');
Route::post('/register',[GuestController::class, 'registerPost'])->name('guest.register.post');
Route::get('/register_info',[GuestController::class, 'registerInfo'])->name('guest.registerinfo');

//Student

Route::get('/student',[StudentController::class, 'index'])->name('student.index');
Route::get('/student/logout',[StudentController::class, 'logout'])->name('student.logout');
Route::get('/student/subject/enroll', [StudentController::class, 'showAllSubjectsList'])->name('student.showAllSubjectsList');
Route::post('/student/subject/enroll', [StudentController::class, 'sendJoinRequest'])->name('student.sendJoinRequest');


Route::get('/student/chosen',[StudentController::class, 'chosen'])->name('student.chosen');
Route::get('/student/subject/{code}/index',[StudentController::class, 'subjectIndex'])->name('student.subject.index');

Route::get('/student/subject/{code}/lab',[StudentController::class, 'lab'])->name('student.subject.lab');
Route::get('/student/subject/{code}/lab/{idLab}/join',[StudentController::class, 'showAppointments'])->name('student.subject.lab.idlab.join.get');
Route::post('/student/subject/{code}/lab/{idLab}/join',[StudentController::class, 'joinAppointment'])->name('student.subject.lab.idlab.join.post');
Route::post('/student/subject/{code}/lab/{idLab}/leave',[StudentController::class, 'leaveAppointment'])->name('student.subject.lab.idlab.leave');
Route::get('/student/subject/{code}/lab/{idLab}/swap',[StudentController::class, 'showPossibleSwaps'])->name('student.subject.code.lab.idlab.swap.get');
Route::post('/student/subject/{code}/lab/{idLab}/swap',[StudentController::class, 'performSwap'])->name('student.subject.code.lab.idlab.swap.post');
Route::get('/student/subject/{code}/lab/{idLab}/request',[StudentController::class, 'enterRequest'])->name('student.subject.code.lab.idlab.request.get');
Route::post('/student/subject/{code}/lab/{idLab}/request',[StudentController::class, 'submitRequest'])->name('student.subject.code.lab.idlab.request.post');



//PROJECTS restful
Route::get("/student/subject/{code}/project", [StudentController::class, "projectIndexPage"])->name("student.project.index");
Route::get("/student/subject/{code}/team/available", [StudentController::class, "availableTeams"])->name("student.team.availableTeams");
Route::post("/student/subject/{code}/team/{teamId}/join", [StudentController::class, "joinTeam"])->name("student.team.join");
Route::post("/student/subject/{code}/team/{teamId}/exit", [StudentController::class, "exitTeam"])->name("student.team.exit");
Route::post("/student/subject/{code}/team/create", [StudentController::class, "createTeam"])->name("student.team.create");
Route::post("/student/subject/{code}/team/{idTeam}/lock", [StudentController::class, "lockTeam"])->name("student.team.lock");
Route::post("/student/subject/{code}/team/{idTeam}/unlock", [StudentController::class, "unlockTeam"])->name("student.team.unlock");

//Teacher

Route::get('/teacher',[TeacherController::class, 'index'])->name('teacher.index');
Route::get('/teacher/logout',[TeacherController::class, 'logout'])->name('teacher.logout');
Route::get('/teacher/subject/list',[TeacherController::class, 'getSubjects'])->name('teacher.subject.list');
Route::get('/teacher/subject/{idSubject}/index',[TeacherController::class, 'subjectIndexPage'])->name('teacher.subject.index');

Route::get('/teacher/addSubject',[TeacherController::class, 'addSubjectGet'])->name('teacher.addsubject.get');
Route::post('/teacher/addSubject',[TeacherController::class, 'addSubjectPost'])->name('teacher.addsubject.post');
Route::get  ('/teacher/addSubject/info',[TeacherController::class, 'addSubjectInfo'])->name('teacher.addsubject.info');

Route::get('/teacher/subject/request/list', [TeacherController::class, 'showRequestsList'])->name('teacher.showRequestsList');
Route::post('/teacher/subject/request/list/accept', [TeacherController::class, 'acceptRequest'])->name('teacher.acceptRequest');
Route::post('/teacher/subject/request/list/reject', [TeacherController::class, 'rejectRequest'])->name('teacher.rejectRequest');

Route::get('/teacher/subject/{code}/project', [TeacherController::class, 'showProjects'])->name('teacher.showProjects');
Route::get('/teacher/subject/{code}/project/define', [TeacherController::class, 'showProjectForm'])->name('teacher.showProjectForm');
Route::post('/teacher/subject/{code}/project/removeProject', [TeacherController::class, 'removeProject'])->name('teacher.removeProject');

//Admin

Route::get('/admin',[AdminController::class, 'registerRequests'])->name('admin.index');
Route::get('/admin/requests/register',[AdminController::class, 'registerRequests'])->name('admin.register.requests');
Route::post('/admin/requests/register/addUser',[AdminController::class, 'addUser'])->name('admin.addUser');
Route::post('/admin/requests/register/delete',[AdminController::class, 'deleteRegisterRequest'])->name('admin.deleteRequest.register');

Route::get('/admin/requests/newSubjects',[AdminController::class, 'newSubjectRequests'])->name('admin.newSubject.requests');
Route::post('/admin/requests/newSubjects/addSubject', [AdminController::class, 'addSubject'])->name('admin.addSubject');
Route::post('/admin/requests/newSubjects/delete', [AdminController::class, 'deleteSubjectRequest'])->name('admin.deleteRequest.subject');

Route::get('/admin/subjects/list', [AdminController::class, 'subjectList'])->name('admin.subjects.list');
Route::get('/admin/subjects/{subjectCode}', [AdminController::class, 'subjectIndex'])->name('admin.subject.index');
Route::post('/admin/subjects/{subjectCode}/delete', [AdminController::class, 'deleteSubject'])->name('admin.delete.subject');

Route::post('/admin/subjects/{subjectCode}/deleteTeacher/{idT}', [AdminController::class, 'deleteTeacherFromSubject'])->name('admin.delete.teacher');
Route::post('/admin/subjects/{subjectCode}/deleteStudent/{idSt}', [AdminController::class, 'deleteStudentFromSubject'])->name('admin.delete.student');

Route::get('/admin/subjects/{subjectCode}/lab/list', [AdminController::class, 'labExercisesIndex'])->name('admin.subject.lab');
Route::get('/admin/subjects/{subjectCode}/lab', [AdminController::class, 'labExerciseIndex'])->name('admin.subject.lab.show');
Route::post('/admin/subjects/{subjectCode}/lab/delete', [AdminController::class, 'labExerciseDelete'])->name('admin.subject.lab.delete');
Route::post('/admin/subjects/{subjectCode}/lab/appointment/{idApp}/delete', [AdminController::class, 'deleteAppointment'])->name('admin.subject.lab.app.delete');

Route::get('/admin/subjects/{subjectCode}/project', [AdminController::class, 'projectIndex'])->name('admin.subject.project.index');
Route::post('/admin/subjects/{subjectCode}/project/team/{idTeam}/delete', [AdminController::class, 'deleteTeam'])->name('admin.subject.team.delete');
Route::post('/admin/subjects/{subjectCode}/project/delete', [AdminController::class, 'deleteProject'])->name('admin.subject.project.delete');

Route::get('/admin/users/search', [AdminController::class, 'searchUsers'])->name('admin.users.search.index');
Route::get('/admin/users/search/results', [AdminController::class, 'searchUsersResults'])->name('admin.users.search.results');
Route::post('/admin/users/student/{idS}/delete', [AdminController::class, 'deleteStudentFromSystem'])->name('admin.users.delete.student');
Route::post('/admin/users/teacher/{idT}/delete', [AdminController::class, 'deleteTeacherFromSystem'])->name('admin.users.delete.teacher');
Route::post('/admin/users/admin/{idA}/delete', [AdminController::class, 'deleteAdminFromSystem'])->name('admin.users.delete.admin');

Route::get('/admin/logout', [App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');

//Route::get('/admin/subjects/list', [AdminController::class, 'subjectList'])->name('admin.subjects.list');
//Route::post('/admin/requests/subjects/{id}/delete', [AdminController::class, 'deleteSubject'])->name('admin.delete.subject');
//Route::get('/admin/logout',[AdminController::class, 'logout'])->name('admin.logout');

//Route::post('/admin/addUser',[AdminController::class, 'addUser'])->name('admin.adduser');
//Route::post('/admin/deleteRequest',[AdminController::class, 'deleteRequest'])->name('admin.deleterequest');

