<?php
/**
 *
 * @author Sreten Živković 0008/2018
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
    <script src="{{ asset('js/student/navigacija_script.js') }}" defer></script>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/temp.css') }}" rel="stylesheet">
    <link href="{{ asset('css/student/show_appointments.css') }}" rel="stylesheet">
    <link href="{{asset("css/project.css")}}" rel="stylesheet">

    @yield("page-import", "")
    <title>
        @yield('page-title')
    </title>
</head>
<body>
<div class="container-fluid">
    <div class="row header-with-background pt-3">
        <div class="col-12 d-flex  justify-content-end pb-2 pt-0 ">
            <ul class="nav d-flex align-items-center">
                <li class="nav-item ml-1 mr-1">
                    {{$userName}}
                </li>
                <li class="nav-item ml-1 mr-1">
                    <a class="nav-link btn btn-dark rounded-pill" href="{{ route(Session::get('user')['userType'].'.index') }}">Početna</a>
                </li>
                <li class="nav-item ml-1 mr-1">
                    <a class="nav-link btn btn-dark rounded-pill" href="{{ route(Session::get('user')['userType'].'.logout') }}">Odjavi se</a>
                </li>
            </ul>
        </div>
        <div class="col-12 tabs d-flex align-bottom  nav nav-tabs justify-content-start pt-4" id="nav-div">
            <nav class="">
                <div class="d-flex align-self-end" class="nav">
                    @yield("page-nav")
                </div>
            </nav>
        </div>
    </div>



    @yield('content')

    <div class="row footer">
        <div class="col ">
            <hr style="width: 100%; color: #6c757d;height: 1px" >



                <div class="text-lg-center text-md-center text-sm-center"  >
                    <p class="justify-content-center">© ProLab/Valerijan Matvejev 2018/0257, Slobodan Katanić 2018/0133, Nemanja Lazić 2018/0004, Sreten Živković 2018/0008
                    </p>
                    <p>
                        Elektrotehnički fakultet, Univerzitet u Beogradu
                    </p>

                </div>


        </div>
    </div>


</div>



</body>
</html>
