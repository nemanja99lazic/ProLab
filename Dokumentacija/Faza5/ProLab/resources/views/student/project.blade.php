<?php
/**
 * @note stranica za upravljanje projektima
 * @author  Sreten Živković 0008/2018
 */
$user = Session::get('user')["userObject"];
$userName = $user->forename . " " . $user->surname;
?>
@extends('layout.student_main')
@section("page-title")
    @if($project->notExist)
        Projekat ne postoji.
    @else
        {{$subjectName}} - Projekti
    @endif
@endsection
@section("page-nav")
    <a href="{{route("student.subject.index", $code)}}" class="project-tab-button nav-item ml-3 mr-1 nav-link btn-outline-dark">Stranica predmeta</a>
    <a href="#" class="project-tab-button active nav-item mr-1 nav-link btn-outline-dark" data-tab-id="#project-info">O projektu</a>
    <a href="#" class="project-tab-button nav-item mr-1 nav-link btn-outline-dark" data-tab-id="#team-list">Timovi</a>
    <a href="#" class="project-tab-button nav-item  mr-1 nav-link btn-outline-dark" data-tab-id="#team-create">Kreiraj tim</a>
@endsection
@section("page-import")
    <script>
        window.projectData = {
            @if(!$project->notExist)
            name: "{{$project->name}}",
            idProject: {{$project->idProject}},
            min: {{$project->minMemberNumber}},
            max: {{$project->maxMemberNumber}},
            idSubject: {{$project->idSubject}},
            expirationDate: "{{$project->expirationDate}}",
            idUser: {{$user->idUser}},
            code: "{{$code}}",
            @endif
            notExist: {{$project->notExist? "true" : "false"}}
        };
    </script>
    <script src="{{ asset('js/project.js') }}" defer></script>
@endsection
@section("content")
    <span class ="d-none" id="csrf">@csrf</span>
    <div class="project-tab" id="project-info">

        @if($project->notExist)
            <div class="row">
                <div class="col-12 text-center"><h1 >Projekat ne postoji za ovaj predmet.</h1></div>
            </div>
        @else
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-md-8 col-lg-6 col-xl-4 mt-3">
                    <table class="text-center table border" id="tabela-informacija">
                        <tr>
                            <td colspan="2">
                                <h2 class="font-weight-bold text-center">
                                    {{$subjectName}} - Informacije o projektu
                                </h2>
                            </td>
                        </tr>
                        <tr>
                            <td>Ime projekta</td>
                            <td>{{$project->name}}</td>
                        </tr>
                        <tr>
                            <td>Minimalni broj članova</td>
                            <td>{{$project->minMemberNumber}}</td>
                        </tr>
                        <tr>
                            <td>Maksimalni broj članova</td>
                            <td>{{$project->maxMemberNumber}}</td>
                        </tr>
                        <tr>
                            <td>Datum isteka prijave</td>
                            <td>{{
                                            implode(".",array_reverse(explode("-",$project->expirationDate)))
                                        }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        @endif

    </div>
    <div class="d-none project-tab" id="team-list">
        <div id="my-team" class="d-none">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-6 pt-5">
                    <table  id="my-team-table" class="table  w-100 border">
                        <tr class="">
                            <td colspan="2" class="">
                                <div class="d-flex justify-content-between w-100">
                                    <h3 class="w-75 font-weight-bold">Moj tim</h3>
                                    <button id="delete-exit-my-team" class="btn btn-danger p-2">Obriši ili izađi</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Ime tima:</td>
                            <td id="my-team-name" class="text-right font-weight-bold">Moj tim</td>
                        </tr>
                        <tr class="show-leader text-center">
                            <td colspan="2" >Vi ste lider tima.</td>
                        </tr>
                        <tr>

                            <td colspan="2">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-4 text-left show-leader">
                                        <button class="btn-dark btn" id="lock-team-button">Zaključaj</button>
                                    </div>
                                    <div class="col-4 text-center font-weight-bold" id="locked-status">
                                        Zaključan
                                    </div>
                                    <div class="col-4 text-right show-leader">
                                        <button class="btn-dark btn" id="unlock-team-button">Otključaj</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" id="member" class="text-center text-uppercase font-weight-bold">Članovi</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="p-0" id="my-team-members">

                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-12 text-center font-weight-bold pt-3"><h2>Ostali timovi</h2></div>
            <div class="col-12" id="">
                <div class="row" id="other-teams"></div>
            </div>
        </div>

    </div>
    <div class="d-none project-tab" id="team-create">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-8 col-lg-5 col-xl-4 mt-4">
                <table class="table text-center table-bordered w-100">
                    <tr>
                        <td class="font-weight-bold h2">Kreiranje tima</td>
                    </tr>
                    <tr>
                        <td>
                            <input class="form-control" placeholder="Naziv tima" type="text" id="form-team-name" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div id="form-message" class="col-12 pb-2">

                            </div>
                            <button class="btn d-block w-100 btn-dark" id="form-team-sumbit">Kreiraj tim</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
<body>
