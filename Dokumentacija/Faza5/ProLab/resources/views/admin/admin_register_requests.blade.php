{{--
    Autor: Slobodan Katanic 2018/0133
--}}

@extends('layout.main_admin')

@section('admin_content')

    <div class="row">
        <div class="col-2 mt-5 d-flex flex-column justify-content-start">
            <div class="nav flex-column nav-pills" id="v-pills" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="v-pill-registerRequest" data-toggle="pill" role="tab" aria-controls="v-pills-home" aria-selected="true" href="">Registration requests</a>
                <a class="nav-link newSubjectRequest" id="v-pill-newSubjectRequest" data-toggle="pill" href="" role="tab" aria-controls="v-pills-profile" aria-selected="false">New subject requests</a>
            </div>
        </div>
        <div class="col-10 pt-5">
{{--            <h4 class="mb-5 mt-5">Registration requests</h4>--}}
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

{{--    <div clas="row">--}}
{{--        <div class="col">--}}
{{--            <h4 class="mb-5 mt-5">Registration requests</h4>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="row">--}}
{{--        <div class="col">--}}
{{--tabela--}}
{{--        </div>--}}
{{--    </div>--}}

@endsection

