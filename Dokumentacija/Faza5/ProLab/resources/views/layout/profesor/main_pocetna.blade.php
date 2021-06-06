<!-- Nemanja Lazic 2018/0004 -->
<?php
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
    <meta name="csrf-token" content="{{ csrf_token() }}">  <!-- Treba za AJAX zahteve -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/navbar.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/temp.css') }}" rel="stylesheet">
    <link href="{{asset("css/project.css")}}" rel="stylesheet">
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
        main{
            min-height: 70vh;
        }

    </style>
</head>
<body>
    <div class="container-fluid">
        @include('layout.profesor.header_predmeti_dodavanje_predmeta_zahtevi')

        <main>
            @yield('content')
        </main>

        @include('layout.profesor.footer')
    </div>
</body>
</html>
