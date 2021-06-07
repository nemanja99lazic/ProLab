{{--
    Autor: Slobodan Katanic 2018/0133
--}}

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/admin/admin.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <title>Admin</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row header-with-background pt-3">
            <div class="col-12 d-flex justify-content-end pb-2 pt-0">
                <ul class="nav d-flex align-items-center">
                    <li class="nav-item ml-1 mr-1">
                        {{ Session::get('user')['userObject']->forename.' '.Session::get('user')['userObject']->forename }}
                    </li>
                    <li class="nav-item ml-1 mr-1">
                        <a class="nav-link btn menu-button rounded-pill" href="{{ route(Session::get('user')['userType'].'.index') }}">Početna</a>
                    </li>
                    <li class="nav-item ml-1 mr-1">
                        <a class="nav-link btn menu-button rounded-pill" href="{{ route(Session::get('user')['userType'].'.logout') }}">Odjavi se</a>
                    </li>
                </ul>
            </div>
{{--            <div class="col-12 d-flex flex-column justify-content-center align-items-center">--}}
{{--                <img src="/images/ProLabLOGO.png" class="rounded p-0 m-0" width="7%">--}}
{{--            </div>--}}
            <div class="col-12 tabs d-flex align-bottom  nav nav-tabs justify-content-start pt-4 pl-2" id="nav-div">
                <nav>
                    <div class="d-flex align-self-end" class="nav">
                        <a class="nav-item nav-link btn-outline-dark {{ request()->is('admin/requests/*') || request()->is('admin') ? 'active' : ''}}" id="nav-request-tab" data-toggle="tab" href="">Zahtevi</a>
                        <a class="nav-item nav-link btn-outline-dark {{ request()->is('admin/subjects/*') ? 'active' : ''}}" id="nav-subject-tab" data-toggle="tab" href="">Predmeti</a>
                        <a class="nav-item nav-link btn-outline-dark {{ request()->is('admin/users/*') ? 'active' : ''}}" id="nav-user-tab" data-toggle="tab" href="">Korisnici</a>
                    </div>
                </nav>
            </div>
        </div>

        @yield('admin_content')

{{--        <div class="row footer">--}}
{{--            <div class="col-12 m-3 text-center">--}}
{{--                <hr>--}}
{{--                <div class="font-weight-bold font-italic">Elektrotehnički fakultet, Univerzitet u Beogradu</div>--}}
{{--                <div>Slobodan Katanic</div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="row footer">
            <footer class="page-footer col-12" >
                <hr>
                <div class="text-lg-center text-md-center text-sm-center"  >
                    <p class="justify-content-center">© ProLab/Valerijan Matvejev 2018/0257, Slobodan Katanić 2018/0133, Nemanja Lazić 2018/0004, Sreten Živković 2018/0008
                        <br/>
                        Elektrotehnički fakultet, Univerzitet u Beogradu
                    </p>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>
