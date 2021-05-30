<!--
    Nemanja Lazic 2018/0004
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/teacher/requests_list_script.js') }}" defer></script>
    <link rel="stylesheet" href="{{asset('css/teacher/requests_list_style.css')}}">
    <title>Requests list</title>
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
                <h2 class="mb-5 mt-5">Lista zahteva</h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-bordered table-striped text-center" id="teacher_requests_table">
                    <tr>
                        <th>#</th>
                        <th>Predmet</th>
                        <th>Tip zahteva</th>
                        <th>Podnosilac zahteva</th>
                        <th></th>
                        <th></th>
                    </tr>

                    @if(count($requests) > 0)
                        @foreach ($requests as $request)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$request->name}}</td>
                                <td>Pristup kursu</td>
                                <td>{{$request->email}}</td>
                                <td>
                                    <form action="{{ route('teacher.acceptRequest') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="idRequest" id="idRequest" value="{{$request->idRequest}}">
                                        <button type="submit" class="btn btn-outline-success" id="btn-prihvati-zahtev">Prihvati</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('teacher.rejectRequest') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="idRequest" id="idRequest" value="{{$request->idRequest}}">
                                        <button type="submit" class="btn btn-outline-danger" id="btn-odbij-zahtev">Odbij</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </div>
        </div>
        <div class="row">
            {{$requests->links()}}
        </div>
        <div class="row">
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <p id="alert-ispis"></p>
            </div>
        </div>
    </div>
</body>
</html>
