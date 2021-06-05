<!--
    Nemanja Lazic 2018/0004
-->

@extends('layout.main')
@section('content')
    <link rel="stylesheet" href="{{asset("student.show_all_subjects_style.css")}}">
    
    <div clas="row">
        <div class="col-12">
            <h2 class="mb-5 mt-5">Lista predmeta koje možete da prijavite</h2>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <table class="table table-bordered table-striped text-center" id="subject-enrollment-table">
                <tr>
                    <th>Sifra</th>
                    <th>Ime</th>
                    <th></th>
                </tr>
                @if(count($subjects) > 0)
                    @foreach ($subjects as $subject)
                        <tr>
                            <td>{{$subject->code}}</td>
                            <td>{{$subject->name}}</td>
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
