<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/admin/admin.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="row header">
        <div class="col-5 tabs d-flex flex-column justify-content-end p-0">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <input hidden value="{{ request()->subjectCode }}" id="subjectCode">
                    <a class="pill nav-item nav-link btn-outline-dark {{ request()->routeIs('admin.subject.index') ? 'active' : ''}}" id="nav-subjectPage-tab" data-toggle="tab" href="" role="tab" aria-controls="nav-home" aria-selected="true">Stranica predmeta</a>
                    <a class="pill nav-item nav-link btn-outline-dark {{ request()->is('admin/subjects/*/lab*') ? 'active' : ''}}" id="nav-lab-tab" data-toggle="tab" href="" role="tab" aria-controls="nav-profile" aria-selected="false">Laboratorijske vezbe</a>
                    <a class="pill nav-item nav-link btn-outline-dark {{ request()->is('admin/subjects/*/project/*') ? 'active' : ''}}" id="project-user-tab" data-toggle="tab" href="" role="tab" aria-controls="nav-contact" aria-selected="false">Projekat</a>
                </div>
            </nav>
        </div>
        <div class="col-2 d-flex flex-column justify-content-center align-items-center">
            <img src="/images/ProLabLOGO.png" class="rounded" width="150%">
        </div>
        <div class="col-3 offset-2 d-flex flex-row justify-content-end">
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
