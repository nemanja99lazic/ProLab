{{--
    Autor: Slobodan Katanic 2018/0133
--}}

@extends('layout.main_admin')

@section('admin_content')

    <div class="row">
        <div class="col-2 mt-5 d-flex flex-column justify-content-start">
            <ul class="nav nav-pills">
                <li class="nav-item pill-request" id="pill-reg">
                    <a class="nav-link active" id="v-pill-registerRequest" data-toggle="pill" href="">Registracija</a>
                </li>
                <li class="nav-item pill-request" id="pill-new">
                    <a class="nav-link" id="v-pill-newSubjectRequest" data-toggle="pill" href="">Kreiranje predmeta</a>
                </li>
            </ul>
        </div>
        <div class="col-10 pt-5">
            <table class="table table-bordered table-striped text-center mytable" id="registration_requests">
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
                            <form action="{{ route('admin.addUser') }}" method="post">
                                @csrf
                                <input type="hidden" name="email" id="email" value="{{ $req->email }}">
                                <button type="submit" class="btn btn-outline-success p-1 m-0">Accept</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('admin.deleteRequest.register') }}" method="post">
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

@endsection

