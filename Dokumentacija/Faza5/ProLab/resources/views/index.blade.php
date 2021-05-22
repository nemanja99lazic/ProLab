<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="{{ asset('js/app.js') }}" defer></script>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <title>Document</title>
    </head>

    <body>
        <div class="jumbotron">
            <div class="container">
                <h1>ProLab</h1>
                <a href="{{ route(Session::get('user')['userType'].'.logout') }}">Logout</a>
            </div>
        </div>
        <div class="container">
            <div clas="row">
                <div class="col">
                    @if(Session::get('user') != null)
                        {{ Session::get('user')['userObject']->forename." ".Session::get('user')['userObject']->surname }}
                    @endisset
                </div>
            </div>
        </div>

    </body>
</html>

