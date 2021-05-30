<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/navbar.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/temp.css') }}" rel="stylesheet">
    <title>Document</title>
    <style>
        hr{
            height: 20px;
            background-color: #000066;
            border: none;
            padding: 0;
        }

    </style>
</head>
<body>
    <div class="container-fluid">


        @include('layout/header')
        @yield('content')
        @include('layout/footer')


    </div>



</body>
</html>
