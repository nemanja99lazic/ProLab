@extends('layout.nemanja_main_layout')
@section('contentInsideTheContainer')

<link rel="stylesheet" href="{{asset('css/teacher/show_projects_style.css')}}">

<div class="row">
    <div class="col text-center">
        <button class="btn btn-primary" id="btn-definisi-projekat" action="{{url("/teacher/subject/{code}/project/removeProject")}}">Definiši projekat</button>
    </div>
</div>
<div class="row">
    <div class="col">
        <table class="table table-bordered table-striped text-center">
            <tr>
                <th>Naziv projekta</th>
                <th>Min. broj članova</th>
                <th>Maks. broj članova</th>
                <th>Rok</th>
                <th></th>
            </tr>
            @foreach ($projects as $project)
                <tr>
                    <td>{{$project->name}}</td>
                    <td>{{$project->minMemberNumber}}</td>
                    <td>{{$project->maxMemberNumber}}</td>
                    <td>{{$project->expirationDate}}</td>
                    <td>
                        <form action="{{route('teacher.deleteProject', ['code' => $code])}}" method="post">
                            @csrf
                            <input type="hidden" name="idProject" id="idProject" value="{{$project->idProject}}">
                            <button type="submit" class="btn btn-danger" id="btn-ukloni-projekat">Ukloni projekat</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>

@endsection