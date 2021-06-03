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
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
{{--        <script src="{{ asset('js/guest/register_info.js') }}" defer></script>--}}
        <title>Register</title>
    </head>
    <body>
{{--        <div class="jumbotron p-5">--}}
{{--            <div class="container text-center">--}}
{{--                <img src="images\ProLabLOGO.jpg" class="rounded img-thumbnail img-fluid" width="15%">--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="container pt-5">
            @if(!empty(Session::get('success')))
                {{ Session::forget('success') }}
                <div class="row">
                    <div class="col">
                        <div class="alert alert-success alert-dismissible" id="alert-register-info" role="alert">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            Vas zahtev za kreiranje naloga je uspesno poslat.
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-5 offset-3 m-auto">
                    <form action="{{ route('guest.register.post') }}" method="post">
                        @csrf
                        <table class="table text-center w-100">
                            <tr class="text-center">
                                <td colspan="2" class="font-weight-bold h3">Kreiranje novog naloga</td>
                            </tr>
                            <tr>
                                <td class="w-50">
                                    @if($errors->first('firstname'))
                                        <input type="text" class="form-control m-1 is-invalid" name="firstname" id="firstname" autocomplete="off" placeholder="first name" value="{{old("firstname")}}">
                                        <div class="text-danger text-left h6 small">{{ $errors->first('firstname') }}</div>
                                    @else
                                        <input type="text" class="form-control m-1" name="firstname" id="firstname" autocomplete="off" placeholder="first name" value="{{old("firstname")}}">
                                    @endif
                                </td>
                                <td>
                                    @if($errors->first('lastname'))
                                        <input type="text" class="form-control m-1 is-invalid" name="lastname" id="lastname" autocomplete="off" placeholder="last name" value="{{old("lastname")}}">
                                        <div class="text-danger text-left h6 small">{{ $errors->first('lastname') }}</div>
                                    @else
                                        <input type="text" class="form-control m-1" name="lastname" id="lastname" autocomplete="off" placeholder="last name" value="{{old("lastname")}}">
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    @if($errors->first('username'))
                                        <input type="text" class="form-control m-1 is-invalid" name="username" id="username" autocomplete="off" placeholder="username" value="{{old("username")}}">
                                        <div class="text-danger text-left h6 small">{{ $errors->first('username') }}</div>
                                    @elseif(Session::get('errorUsername') != null)
                                        <input type="text" class="form-control m-1 is-invalid" name="username" id="username" autocomplete="off" placeholder="username" value="{{old("username")}}">
                                        <div class="text-danger text-left h6 small">{{Session::get('errorUsername')}}</div>
                                    @else
                                        <input type="text" class="form-control m-1" name="username" id="username" autocomplete="off" placeholder="username" value="{{old("username")}}">
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    @if($errors->first('password'))
                                        <input type="password" class="form-control m-1 is-invalid" name="password" id="password" autocomplete="off" placeholder="password">
                                        <div class="text-danger text-left h6 small">{{ $errors->first('password') }}</div>
                                    @else
                                        <input type="password" class="form-control m-1" name="password" id="password" autocomplete="off" placeholder="password">
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    @if($errors->first('email'))
                                        <input type="text" class="form-control m-1 is-invalid" name="email" id="email" autocomplete="off" placeholder="email" value="{{old("email")}}">
                                        <div class="text-danger text-left h6 small">{{ $errors->first('email') }}</div>
                                    @elseif(Session::get('errorEmail') != null)
                                        <input type="text" class="form-control m-1 is-invalid" name="email" id="email" autocomplete="off" placeholder="email" value="{{old("email")}}">
                                        <div class="text-danger text-left h6 small">{{Session::get('errorEmail')}}</div>
                                    @else
                                        <input type="text" class="form-control m-1" name="email" id="email" autocomplete="off" placeholder="email" value="{{old("email")}}">
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left" colspan="2">
                                    <span class="mr-5 ml-2 pr-5">User type:</span>
                                    <input type="radio" name="usertype" id="student" value="student" checked>
                                    <label for="student">student</label>
                                    &nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="usertype" id="teacher" value="teacher">
                                    <label for="teacher">teacher</label>
                                    &nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="usertype" id="adimin" value="admin">
                                    <label for="adimin">admin</label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="submit" value="Register" class="btn btn-dark w-100">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Imate nalog? <a href="{{ route('guest.login.get') }}" class="font-weight-bold"><u>Ulogujte se ovde</u></a>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
