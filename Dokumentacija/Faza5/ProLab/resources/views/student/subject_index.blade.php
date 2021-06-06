<?php
/**
 * @note HTML šablon za listu predmeta
 * @author  zvk17
 */
?>
@extends('layout.student_main')
@section("page-title")
    {{$subjectTitle}} - Stranica predmeta
@endsection

@section('page-nav')
    <input hidden value="{{ request()->code }}" id="sifraPredmeta">
    <input hidden value="{{ request()->idLab }}" id="sifraLaba">

    <a class="project-tab-button active nav-item ml-3 mr-1 nav-link btn-outline-dark {{ request()->is('student/subject/*/index')  ? 'active' : ''}}" id="nav-subject-tab" data-toggle="tab" href="" role="tab" aria-controls="nav-home" aria-selected="true" style="font-size: medium">Stranica predmeta</a>
    <a class="project-tab-button  nav-item mr-1 nav-link btn-outline-dark {{ request()->is('student/subject/*/lab') || request()->is('student/subject/*/lab/*') ? 'active' : ''}}" id="nav-lab-tab" data-toggle="tab" href="" role="tab" aria-controls="nav-profile" aria-selected="false"style="font-size: medium" >Laboratorijske vežbe</a>
    <a class="project-tab-button  nav-item mr-1 nav-link btn-outline-dark {{ request()->is('student/subject/*/project')  ? 'active' : ''}}" id="nav-project-tab" data-toggle="tab" href="" role="tab" aria-controls="nav-contact" aria-selected="false"style="font-size: medium" >Projekat</a>

@endsection

@section('content')

    <div class="row d-flex justify-content-center">
        <div class="col-12 col-xl-8 col-lg-10">
            <h1 class="text-center">{{$subjectTitle}}</h1>
        </div>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col-12 col-xl-6 col-lg-8">
            <table class="table table-striped table-hover">
                <tr>
                    <th>Predavači</th>
                    <th>Kontakt</th>
                </tr>
                @foreach ($teacherList as $teacher)
                    <tr>
                        <td>{{$teacher->forename . " " . $teacher->surname}}</td>
                        <td><a href="mailto:{{$teacher->email}}">{{$teacher->email}}</a></td>
                    </tr>
                @endforeach

            </table>
        </div>
    </div>

@endsection

