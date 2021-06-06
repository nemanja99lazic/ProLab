{{--
    Autor: Slobodan Katanic 2018/0133
--}}

@extends('layout.main_admin')

@section('admin_content')

    <div class="row ml-5 mr-5">
        <div class="col-2 mt-5 d-flex flex-column justify-content-start">
            <ul class="nav flex-column nav-pills">
                <li class="nav-item pill-request" id="pill-reg">
                    <a class="nav-link active" id="v-pill-registerRequest" data-toggle="pill" href="">Registracija</a>
                </li>
                <li class="nav-item pill-request" id="pill-new">
                    <a class="nav-link" id="v-pill-newSubjectRequest" data-toggle="pill" href="">Kreiranje predmeta</a>
                </li>
            </ul>
        </div>
        <div class="col-10 pt-5">
            @if(count($regRequests) > 0)
                <table class="table table-striped table-borderless mytable" id="registration_requests">
                    <tr>
                        <th>#</th>
                        <th>Ime</th>
                        <th>Prezime</th>
                        <th>Korisničko ime</th>
                        <th>Sifra</th>
                        <th>Email</th>
                        <th>Tip</th>
                        <th>Radnja</th>
                    </tr>
                    @foreach($regRequests as $req)
                        <tr>
                            <td>{{ $loop->iteration.'.' }}</td>
                            <td class="align-middle">{{explode(',', $req->username)[1]}}</td>
                            <td class="align-middle">{{explode(',', $req->username)[2]}}</td>
                            <td class="align-middle">{{explode(',', $req->username)[0]}}</td>
                            <td class="align-middle">{{$req->password}}</td>
                            <td class="align-middle">{{$req->email}}</td>
                            <td class="align-middle">{{$req->userType == 't' ? 'profesor' : ($req->userType == 's' ? 'student' : 'admin')}}</td>
                            <td class="border-right-0 align-middle">
                                <button class="btn btn-outline-success p-1" data-toggle="modal" data-target="{{ '#modal1'.$req->idRequest }}">Prihvati</button>
                                <div class="modal fade" id="{{ 'modal1'.$req->idRequest }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Upozorenje!</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Da li zaista želite da prihvatite zahtev za registraciju?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('admin.addUser') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="email" id="email" value="{{ $req->email }}">
                                                    <button type="submit" class="btn btn-success">Prihvati zahtev</button>
                                                </form>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Otkaži</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-outline-danger p-1 ml-2" data-toggle="modal" data-target="{{ '#modal2'.$req->idRequest }}">Odbij</button>
                                <div class="modal fade" id="{{ 'modal2'.$req->idRequest }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Upozorenje!</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Da li zaista želite da odbijete zahtev za registraciju?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('admin.deleteRequest.register') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="email" id="email" value="{{ $req->email }}">
                                                    <button type="submit" class="btn btn-danger">Odbij zahtev</button>
                                                </form>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Otkaži</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <div class="col mt-2">
                    <div class="row">
                        <div class="col">
                            <div class="alert alert-info alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <span class="h4">Nema zahteva za registraciju.</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

