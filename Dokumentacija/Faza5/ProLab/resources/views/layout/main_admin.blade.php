<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/admin.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row header">
            <div class="col-3 tabs d-flex flex-column justify-content-end p-0">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link btn-outline-dark {{ request()->is('admin/requests/*') || request()->is('admin') ? 'active' : ''}}" id="nav-request-tab" data-toggle="tab" href="" role="tab" aria-controls="nav-home" aria-selected="true">Requests</a>
                        <a class="nav-item nav-link btn-outline-dark {{ request()->is('admin/subjects/*') ? 'active' : ''}}" id="nav-subject-tab" data-toggle="tab" href="" role="tab" aria-controls="nav-profile" aria-selected="false">Subjects</a>
                        <a class="nav-item nav-link btn-outline-dark" id="nav-user-tab" data-toggle="tab" href="" role="tab" aria-controls="nav-contact" aria-selected="false">Users</a>
                    </div>
                </nav>
{{--                <div class="tab-content" id="nav-tabContent">--}}
{{--                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">ALO</div>--}}
{{--                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">ALO</div>--}}
{{--                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">ALO</div>--}}
{{--                </div>--}}
{{--                    <div>--}}
{{--                        <button class="btn btn-dark my-btn-tab">Zahtevi--}}
{{--                            <span class="badge badge-danger" id="request-number"></span>--}}
{{--                        </button>--}}
{{--                        <button class="btn btn-dark my-btn-tab">Predmeti</button>--}}
{{--                        <button class="btn btn-dark my-btn-tab">Korisnici</button>--}}
{{--                    </div>--}}
{{--                    <div class="">--}}
{{--                        <button class="btn btn-dark">Početna</button>--}}
{{--                        <button class="btn btn-dark">Odjava</button>--}}
{{--                    </div>--}}

            </div>
            <div class="col-6 d-flex flex-column justify-content-center text-center">
{{--                <img src="images\ProLabLOGO.jpg" class="rounded img-thumbnail img-fluid" width="30%">--}}
                <h1>ProLab</h1>
            </div>
            <div class="col-1 offset-2 d-flex flex-column justify-content-start p-2">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link btn btn-dark" href="{{ route(Session::get('user')['userType'].'.logout') }}">Logout</a>
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
