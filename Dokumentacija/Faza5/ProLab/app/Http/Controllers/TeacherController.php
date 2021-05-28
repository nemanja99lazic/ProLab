<?php
/**
 * Autor: Slobodan Katanic 2018/0133
 */
namespace App\Http\Controllers;

use App\NewSubjectRequest;
use App\NewSubjectRequestTeaches;
use App\User;
use Illuminate\Http\Request;
use App\Teacher;
use MongoDB\Driver\Session;

/**
 * TeacherController - klasa koja implemenitra logiku funckionalnosti za tip korisnika profesor.
 *
 * @version 1.0
 */
class TeacherController extends Controller {
    /**
     * Kreiranje nove instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('teacherMiddleware');
    }

    /**
     * Funkcija koja prikazuje pocetni stranicu profesora.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\
     */
    public function index() {
        return view('teacher/teacher_index');
    }

    /**
     * Funcikcija koja sluzi za logout profesora.
     *
     * @param Request $request Request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request) {
        $request->session()->forget('user');
        return redirect()->to(url('/'));
    }

    /**
     * Funcija za prikaz forme za dodavanje novog predmeta.
     *
     * @param Request $request Request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function addSubjectGet(Request $request) {
        $teachers = Teacher::where('idTeacher', '!=', $request->session()->get('user')['userObject']->idUser)->get();
        return view('teacher/teacher_create_subject', ['teachers' => $teachers, 'success' => $request->get('success')]);
    }

    /**
     * Funkcija predstavlja obradu POST zahteva poslatog za kreiranje novog predmeta
     * od strane profesora.
     *
     * @param Request $request Request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addSubjectPost(Request $request) {
        $request->validate([
            'name' => 'required'
        ]);
        $teachers = $request->get('teachers_select');
        $teacher = $request->session()->get('user')['userObject'];

        $newSubjectRequest = new NewSubjectRequest;
        $newSubjectRequest->idTeacher = $teacher->idUser;
        $newSubjectRequest->subjectName = $request->get('name');
        $newSubjectRequest->save();
        $requestId = $newSubjectRequest->idRequest;

        if ($teachers != null) {
            foreach ($teachers as $teacher) {
                $newSubjectRequestTeaches = new NewSubjectRequestTeaches;
                preg_match('/\((.+)\)/', $teacher, $email);
                $user = User::where('email', '=', $email[1])->first();
                $newSubjectRequestTeaches->idTeacher = $user->idUser;
                $newSubjectRequestTeaches->idRequest = $requestId;
                $newSubjectRequestTeaches->save();
            }
        }

        $newSubjectRequestTeaches = new NewSubjectRequestTeaches;
        $newSubjectRequestTeaches->idTeacher = $request->session()->get('user')['userObject']->idUser;
        $newSubjectRequestTeaches->idRequest = $requestId;
        $newSubjectRequestTeaches->save();

        //return redirect()->to(url('teacher/addSubject/info'));
        $request->session()->put('success', 'yes');
        return redirect()->route('teacher.addsubject.get');
    }

    /**
     * Fukcija koja prikazuje profesoru informaije od odredjenom predmetu.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function addSubjectInfo() {
        return view('teacher/teacher_create_subject_info');
    }
}
