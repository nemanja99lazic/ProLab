<?php
/**
 *
 * @author zvk17 koristi Valerijanov footer
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
    <title>
        @yield('page-title')
    </title>
    <style>
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
    <div class="row header mb-5">

        @include('layout/subject_header')

    </div>



    @yield('content')





    <div class="row">
        <div class="col fixed-bottom">
            <hr style="width: 100%; color: #6c757d;height: 1px" >






            <footer class="page-footer bg-light " >

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


</div>



</body>
</html>
