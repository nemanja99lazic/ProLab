<!--
    Nemanja Lazic 2018/0004
-->

@extends('layout.student_main')

@section("page-title")
    Prijava predmeta
@endsection


@section("page-nav")
    <a href="{{route("student.chosen")}}" class="project-tab-button nav-item ml-3 mr-1 nav-link btn-outline-dark">Izabrani predmeti</a>
    <a href="#"  class="active project-tab-button nav-item mr-1 nav-link btn-outline-dark">Prijava predmeta</a>
@endsection
@section("page-import")
    <link rel="stylesheet" href="{{asset("student.show_all_subjects_style.css")}}">
@endsection
@section('content')
    <div clas="row">
        <div class="col-12">
            <h2 class="mb-5 mt-5 font-weight-bold text-center">Lista predmeta koje možete da prijavite</h2>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <table class="table table-bordered table-striped text-center" id="subject-enrollment-table">
                <tr>
                    <th>Ime</th>
                    <th>Šifra</th>
                    <th></th>
                </tr>
                @if(count($subjects) > 0)
                    @foreach ($subjects as $subject)
                        <tr>
                            <td>{{$subject->name}}</td>
                            <td>{{$subject->code}}</td>

                            <td>
                                <form action="{{ route('student.sendJoinRequest') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="idSubject" id="idSubject" value="{{$subject->idSubject}}">
                                    <button type="submit" class="btn btn-outline-primary">Prijavi predmet</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>
    </div>
    <div class="row">
        {{$subjects->links()}}
    </div>
@endsection
