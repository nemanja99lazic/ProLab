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

