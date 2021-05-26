<!-- Prilagodjen Valerijanov layout main.blade.php -->

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!--  Cemu sluzi navbar.js ??? -->
    <title>ProLab</title>
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
    <div class="container">
        <!-- Kad se doda header, ovo treba da se izmeni -->
        <div class="row">
            <header>

            </header>
        </div>

        @yield('contentInsideTheContainer')

        @include('layout.footer')
    </div>

</body>
</html>
