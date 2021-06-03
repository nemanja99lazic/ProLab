<?php
/**
 * @note stranica za upravljanje projektima
 * @author  zvk17
 */
$user = Session::get('user')["userObject"];
$userName = $user->forename . " " . $user->surname;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/navbar.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/temp.css') }}" rel="stylesheet"/>
    <link href="{{ asset("css/project.css") }}" rel="stylesheet"/>
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
    <title>
        @if($project->notExist)
            Projekat ne postoji.
        @else
            {{$subjectName}} - Projekti
        @endif
    </title>
    <style>
        body {
            margin:0;
            padding:0;
        }
        hr{
            height: 20px;
            background-color: #000066;
            border: none;
            padding: 0;
        }
        .blueHeader{
            background-color: #3d7cba;
        }

    </style>
</head>
<body>
<span class ="d-none" id="csrf">@csrf</span>
<div class="container-fluid">
    <div class="row header mt-2">
        <div class="col-12 d-flex  justify-content-end pb-2 pt-0 ">
            <ul class="nav d-flex align-items-center">
                <li class="nav-item ml-1 mr-1">
                    {{$userName}}
                </li>
                <li class="nav-item ml-1 mr-1">
                    <a class="nav-link btn btn-dark" href="{{ route(Session::get('user')['userType'].'.index') }}">Početna</a>
                </li>
                <li class="nav-item ml-1 mr-1">
                    <a class="nav-link btn btn-dark" href="{{ route(Session::get('user')['userType'].'.logout') }}">Odjavi se</a>
                </li>
            </ul>
        </div>

        <div class="col-12 d-flex justify-content-center text-center">
            <!--<img class="header-logo" src="" width="150px" class="img-fluid">
            -->
        </div>
        <div class="col-12 tabs d-flex" id="nav-div">
            <nav>
                <div class="nav">
                    <button class="project-tab-button active nav-item m-1 nav-link btn-dark" data-tab-id="#project-info">Informacije o projektu</button>
                    <button class="project-tab-button nav-item m-1 nav-link btn-dark" data-tab-id="#team-list">Dostupni timovi</button>
                    <button class="project-tab-button nav-item m-1 nav-link btn-dark" data-tab-id="#team-create">Kreiraj tim</button>
                </div>
            </nav>
        </div>
    </div>
    <main id="main">
        <div class="project-tab" id="project-info">

                @if($project->notExist)
                    <div class="row">
                        <div class=col-12"><h1>Projekat ne postoji za ovaj predmet.</h1></div>
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
                                        <div class="col-4 text-center font-weight-bold" id="locked-status">Zaključan</div>
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
            <div id="other-teams">

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

    </main>



    <div class="row">
        <footer class="page-footer bg-light col-12" >
            <hr style="width: 100%; color: #000066 " >
            <div class="text-lg-center text-md-center text-sm-center"  >
                <p class="justify-content-center">© ProLab/Valerijan Matvejev 2018/0257, Slobodan Katanić 2018/0133, Nemanja Lazić 2018/0004, Sreten Živković 2018/0008
                    <br/>
                    Elektrotehnički fakultet, Univerzitet u Beogradu
                </p>


            </div>

        </footer>
    </div>


</div>

<script src="{{ asset('js/project.js') }}"></script>

</body>
</html>

@section("content")
    <h1></h1>



    <script></script>
@endsection
