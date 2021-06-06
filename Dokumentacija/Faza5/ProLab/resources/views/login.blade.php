{{--

    Autor: Slobodan Katanic 2018/0133

--}}

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="{{ asset('js/app.js') }}" defer></script>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <title>Log in</title>
    </head>
    <body>
        <div class="jumbotron p-0">
            <div class="container text-center">
                <img src="/images/ProLabLOGO.png" class="rounded" width="30%">
            </div>
        </div>
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-md-8 col-lg-5 col-xl-4">
                    <form action="{{ route('guest.login.post') }}" method="post">
                        @csrf
                        <table class="table text-center table-bordered w-100">
                            <tr class="text-center">
                                <td class="font-weight-bold h2">Login</td>
                            </tr>
                            <tr>
                                <td>
                                    @if($errors->first('username'))
                                        <input type="text" class="form-control m-1 is-invalid" name="username" id="username" autocomplete="off" placeholder="korisnicko ime" value="{{old("username")}}">
                                        <div class="text-danger text-left h6 small">{{ $errors->first('username') }}</div>
                                    @elseif(Session::get('errorUsername') != null)
                                        <input type="text" class="form-control m-1 is-invalid" name="username" id="username" autocomplete="off" placeholder="korisnicko ime" value="{{old("username")}}">
                                        <div class="text-danger text-left h6 small">{{Session::get('errorUsername')}}</div>
                                    @else
                                        <input type="text" class="form-control m-1" name="username" id="username" autocomplete="off" placeholder="korisnicko ime" value="{{old("username")}}">
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    @if($errors->first('password'))
                                        <input type="password" class="form-control m-1 is-invalid" name="password" id="password" autocomplete="off" placeholder="lozinka">
                                        <div class="text-danger text-left h6 small">{{ $errors->first('password') }}</div>
                                    @elseif(Session::get('errorPassword') != null)
                                        <input type="password" class="form-control m-1 is-invalid" name="password" id="password" autocomplete="off" placeholder="lozinka">
                                        <div class="text-danger text-left h6 small">{{Session::get('errorPassword')}}</div>
                                    @else
                                        <input type="password" class="form-control m-1" name="password" id="password" autocomplete="off" placeholder="lozinka">
                                    @endif
                                </td>
                            </tr>
                            <tr class="text-center">
                                <td>
                                    <input type="submit" value="Log in" class="btn btn-dark w-100">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Nemate nalog? <a href="{{ route('guest.register.get') }}" class="font-weight-bold"><u>Registrujte se ovde</u></a>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>

