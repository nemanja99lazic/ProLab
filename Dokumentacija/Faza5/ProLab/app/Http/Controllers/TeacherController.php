<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Teacher;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('teacherMiddleware');
    }

    public function index() {
        return view('teacher/teacher_index');
    }

    public function logout(Request $request) {
        $request->session()->forget('user');
        return redirect()->to(url('/'));
    }

    public function addSubjectGet(Request $request) {
        $teachers = Teacher::where('idTeacher', '!=', $request->session()->get('user')['userObject']->idUser)->get();
        return view('teacher/teacher_create_subject', ['teachers' => $teachers]);
    }

    public function addSubjectPost() {

    }
}
