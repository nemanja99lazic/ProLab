<?php
//Autor: Valerijan Matvejev 2018/0257 ;   Ispis svih odabranih predmeta
?>
@extends('layout.student_main')

@section("page-title")
    Izabrani predmeti
@endsection


@section("page-nav")
    <a href="#" class="project-tab-button active nav-item ml-3 mr-1 nav-link btn-outline-dark">Izabrani predmeti</a>
    <a href="{{route("student.showAllSubjectsList")}}" class="project-tab-button nav-item mr-1 nav-link btn-outline-dark">Prijava predmeta</a>
@endsection
@section('content')
    <br>
    <h3 class="font-weight-bold text-center border-bottom-12"  >Spisak predmeta koje ste izabrali</h3>
    <br>
    <div class="row justify-content-center">
        <div class="col-auto">
            <table class="table table-bordered"style="width: 80vh" >
                <thead class="thead-light">
                <tr>

                    <th  class="font-weight-bold text-center" style="width: 50%" scope="col" >Predmet</th>
                    <th class="font-weight-bold text-center" style="width: 50%"scope="col">Stranica</th>

                </tr>
                </thead>
                <tbody>

                @foreach($subjects as $subject)


                    <tr style="width: 50%">

                        <td class=" text-center">{{$subject->name}}</td>
                        <td class=" text-center"><a href="{{ route('student.subject.index',$subject->code) }}">Link-></a> </td>

                    </tr>
                @endforeach

                </tbody>
            </table>

        </div>
    </div>
@endsection
