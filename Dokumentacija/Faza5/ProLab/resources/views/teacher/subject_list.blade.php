<?php
/**
 * @note HTML šablon za listu predmeta
 * @author  zvk17
 */

?>
@extends('layout.profesor.main_pocetna')
@section('page-title')
    Lista predmeta
@endsection
@section('content')


    <div class="row pt-5 d-flex justify-content-center">
        <div class="col-12 col-xl-6 col-lg-8">
            <h2 class="text-center font-weight-bold">Lista predmeta na kojima predajete</h2>
            <table class="table table-striped table-hover">
                <tr>
                    <th>Predmet</th>
                    <th>Šifra predmeta</th>
                </tr>
                @foreach ($subjectList as $subject)
                    <tr>
                        <td>{{$subject->name}}</td>
                        <td><a href="{{ route("teacher.subject.index", $subject->code) }}">{{$subject->code}}</a></td>
                    </tr>
                @endforeach

            </table>
        </div>
    </div>
@endsection
