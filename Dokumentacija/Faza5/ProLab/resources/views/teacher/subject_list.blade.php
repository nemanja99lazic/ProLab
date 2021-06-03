<?php
/**
 * @note HTML šablon za listu predmeta
 * @author  zvk17
 */

?>
@extends('layout.main')
@section('content')


    <div class="row d-flex justify-content-center">
        <div class="col-12 col-xl-6 col-lg-8">
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
