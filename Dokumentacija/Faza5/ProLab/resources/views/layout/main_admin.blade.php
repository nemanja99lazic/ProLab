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
    <title>Pocetna</title>
</head>
<body>
    <div class="container">
        <div class="row header">
            <div class="col-3 tabs d-flex flex-column justify-content-end p-0">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link btn-outline-dark {{ request()->is('admin/requests/*') || request()->is('admin') ? 'active' : ''}}" id="nav-request-tab" data-toggle="tab" href="" role="tab" aria-controls="nav-home" aria-selected="true">Zahtevi</a>
                        <a class="nav-item nav-link btn-outline-dark {{ request()->is('admin/subjects/*') ? 'active' : ''}}" id="nav-subject-tab" data-toggle="tab" href="" role="tab" aria-controls="nav-profile" aria-selected="false">Predmeti</a>
                        <a class="nav-item nav-link btn-outline-dark {{ request()->is('admin/users/*') ? 'active' : ''}}" id="nav-user-tab" data-toggle="tab" href="" role="tab" aria-controls="nav-contact" aria-selected="false">Korisnici</a>
                    </div>
                </nav>
            </div>
            <div class="col-6 d-flex flex-column justify-content-center align-items-center">
                <img src="/images/ProLabLOGO.png" class="rounded" width="48%">
            </div>
            <div class="col-3 d-flex flex-row justify-content-end">
                <ul class="nav">
                    <li class="nav-item p-2">
                        <a class="nav-link btn btn-dark rounded-pill" href="{{ route(Session::get('user')['userType'].'.index') }}">Pocetna</a>
                    </li>
                    <li class="nav-item p-2">
                        <a class="nav-link btn btn-dark rounded-pill" href="{{ route(Session::get('user')['userType'].'.logout') }}">Odjavi se</a>
                    </li>
                </ul>
            </div>
        </div>

        @yield('admin_content')

        <div class="row">
            <div class="col-12 fixed-bottom m-5 text-center">
                <hr>
                <div class="font-weight-bold font-italic">Elektrotehnički fakultet, Univerzitet u Beogradu</div>
                <div>Slobodan Katanic</div>
            </div>
        </div>
    </div>
</body>
</html>
