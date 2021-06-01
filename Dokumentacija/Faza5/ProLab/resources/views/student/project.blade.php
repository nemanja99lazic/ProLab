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
    <script>
        window.project = {
            name: "{{$project->name}}",
            idProject: {{$project->idProject}},
            min: {{$project->minMemberNumber}},
            max: {{$project->maxMemberNumber}},
            idSubject: {{$project->idSubject}},
            expirationDate: "{{$project->expirationDate}}",
            code: "{{$code}}"
        };
    </script>
    <title>
        {{$subjectName}} - Projekti
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
            <img class="header-logo" src="{{asset("images/ProLabLOGO.jpg")}}" width="150px" class="img-fluid">

        </div>
        <div class="col-12 tabs d-flex flex-column justify-content-end p-0">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">

                    <a class="nav-item m-1 nav-link btn-dark  request()->is('student/requests/*') || request()->is('admin') ? 'active' : '' " id="nav-request-tab" data-toggle="tab" href="" role="tab">Dostupni timovi</a>
                    <a class="nav-item m-1 nav-link btn-dark request()->is('student/subjects/*') ? 'active' : ''" id="nav-subject-tab" data-toggle="tab" href="" role="tab" aria-controls="nav-profile" >Kreiraj tim</a>

                </div>
            </nav>
        </div>
    </div>
    <main class="row" id="main">
        <div class="col-12">
            <table>
                <tr>
                    <th>Ime</th>
                    <th>Prezime</th>
                    <th>Indeks</th>
                </tr>
                <tr>
                    <td></td>
                </tr>
            </table>
        </div>

    </main>






    <div class="row">
        <footer class="page-footer bg-light col-12" >
            <hr style="width: 100%; color: #000066 " >
            <div class="text-lg-center text-md-center text-sm-center"  >
                <p class="justify-content-center">© ProLab/Valerijan Matvejev 2018/0257, Slobodan Katanić 2018/0133, Nemanja Lazić 2018/0004, Sreten Živković 2018/0008
                </p>
                <p>
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