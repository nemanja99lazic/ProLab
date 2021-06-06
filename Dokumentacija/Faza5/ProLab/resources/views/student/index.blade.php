<!-- Student index strana
    - Nemanja Lazic 2018/0004
-->
<?php

$user = Session::get('user')["userObject"];
$userName = $user->forename . " " . $user->surname;
?>

@extends('layout.student_main')

@section("page-import")
    <link rel="stylesheet" href="{{asset('css/student/index_style.css')}}">
    <script src="{{asset('js/student/index_script.js')}}" defer></script>
    <style>
        main {
            min-height: 65vh;
        }
    </style>
@endsection
@section("page-nav")
    <a href="{{route("student.chosen")}}" class="project-tab-button nav-item ml-3 mr-1 nav-link btn-outline-dark">Izabrani predmeti</a>
    <a href="{{route("student.showAllSubjectsList")}}" class="project-tab-button nav-item mr-1 nav-link btn-outline-dark">Prijava predmeta</a>
@endsection
@section("page-title")
    {{$userName}} - Početna strana
@endsection
@section('content')



    <div class="row">
        <div class="col-md-2" id="prazno-1"></div>
        <div class="col-xs-12 col-md-4 levo">
            <table class="table table-borderless" id='table-student-info'>
                <tr>
                    <td><label for="" id="label-email">E-mail:</label></td>
                    <td class="info"><label for="">{{$email}}</label></td>
                </tr>
                <tr>
                    <td><label for="" id="label-index">Broj indeksa:</label></td>
                    <td class="info">{{$index}}</td>
                </tr>
            </table>
        </div>
        <div class="col-xs-12 col-md-4 desno">
            <h1 id="desno-ime-prezime">{{$forename}} {{$surname}}</h1>
            <h4 id="natpis-student">Student</h4>
            <div id="student-circle-inicijali"></div>
        </div>
        <div class="col-md-2" id="prazno-2"></div>
    </div>
@endsection
