<?php

namespace App\Http\Controllers;

use App\Subject;
use Illuminate\Http\Request;
use App\Attends;
class StudentController extends Controller
{
    public function __construct() {
        $this->middleware('studentMiddleware');
    }

    public function index() {
        return view('index');
    }

    public function logout(Request $request) {
        $request->session()->forget('user');
        return redirect()->to(url('/'));
    }

    public function chosen(Request $request){


        $podaci=$request->session()->get('user');
        // ovo mi uvek vraca peru detlica
        $user=$podaci['userObject'];

        $attends=Attends::where('idStudent','=',2)->get();
        $subjectIds=[];
        foreach($attends as $attend)
            $subjectIds[]=$attend->idSubject;
        $subjects=[];
        foreach($subjectIds as $subjectId)
            $subjects[]=Subject::find($subjectId);

        return view('student/chosen_subjects',['predmeti'=>$subjects]);
    }
}
