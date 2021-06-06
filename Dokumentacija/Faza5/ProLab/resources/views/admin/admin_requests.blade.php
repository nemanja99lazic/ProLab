<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Admin requests</title>
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
                <h2 class="mb-5 mt-5">Registration requests</h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-bordered table-striped text-center" id="registration_requests">
                    <tr>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Email</th>
                        <th>User type</th>
                        <th colspan="2">Action</th>
                    </tr>
                    @foreach($regRequests as $req)
                        <tr>
                            <td>{{explode(',', $req->username)[1]}}</td>
                            <td>{{explode(',', $req->username)[2]}}</td>
                            <td>{{explode(',', $req->username)[0]}}</td>
                            <td>{{$req->password}}</td>
                            <td>{{$req->email}}</td>
                            <td>{{$req->userType}}</td>
                            <td>
                                <form action="{{ route('admin.adduser') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="email" id="email" value="{{ $req->email }}">
                                    <button type="submit" class="btn btn-outline-success p-1 m-0">Accept</button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('admin.deleterequest') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="email" id="email" value="{{ $req->email }}">
                                    <button type="submit" class="btn btn-outline-danger p-1 m-0">Decline</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</body>
</html>
