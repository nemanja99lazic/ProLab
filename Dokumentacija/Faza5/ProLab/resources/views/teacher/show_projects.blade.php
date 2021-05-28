<!-- Nemanja Lazic 2018/0004 -->

@extends('layout.nemanja_main_layout')
@section('contentInsideTheContainer')

<link rel="stylesheet" href="{{asset('css/teacher/show_projects_style.css')}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> <!-- JQUERY CDN - samo za test -->
<script src="{{asset('js/teacher/show_projects_script.js')}}"></script>

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
                <tr id = {{$project->idProject}}>
                    <td>{{$project->name}}</td>
                    <td>{{$project->minMemberNumber}}</td>
                    <td>{{$project->maxMemberNumber}}</td>
                    <td>{{$project->expirationDate}}</td>
                    <td>
                        <!-- Korisceni data-* atributi za slanje razlicitih vrednosti kroz button, pogledaj dokumentaciju za to -->
                        <button type="button" class="btn btn-danger btn-ukloni-projekat" data-code="{{$code}}" data-idProject="{{$project->idProject}}">Ukloni projekat</button>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
<!-- Alert "Projekat uklonjen" -->
<div class="row">
  <div class="alert alert-info alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">x</button>
      <p id="alert-ispis"></p>
  </div>
</div>
<!-- Dodavanje bootstrap modala (DIJALOGA) -->
<div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Uklanjanje projekta</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Da li ste sigurni da želite da uklonite projekat?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="modal-btn-ukloni">Ukloni</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal" id ="modal-btn-otkazi">Otkaži</button>
        </div>
      </div>
    </div>
  </div>

@endsection