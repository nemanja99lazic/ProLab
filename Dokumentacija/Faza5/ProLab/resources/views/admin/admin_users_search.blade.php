{{--
    Autor: Slobodan Katanic 2018/0133
--}}

@extends('layout/main_admin')

@section('admin_content')

    <div class="row mt-5 mb-3 d-flex flex-row justify-content-center">
        <div class="col-4">
            <form action=" {{ route('admin.users.search.results') }}" method="get">
                <div class="text-center mb-2">
                    <input type="radio" name="search" value="student" id="student" checked> <label for="student">studenti</label>
                    @isset($teachers)
                        <input class="ml-2" type="radio" name="search" value="teacher" id="teacher" checked> <label for="teacher">profesori</label>
                    @else
                        <input class="ml-2" type="radio" name="search" value="teacher" id="teacher"> <label for="teacher">profesori</label>
                    @endisset
                    @isset($admins)
                        <input class="ml-2" type="radio" name="search" value="admin" id="admin" checked> <label for="admin">admini</label>
                    @else
                        <input class="ml-2" type="radio" name="search" value="admin" id="admin"> <label for="admin">admini</label>
                    @endisset
                </div>
                <div class="input-group">
                    @if(!empty(Session::get('searchInput')))
                        <input value="{{ Session::get('searchInput') }}" id="search-field" type="search" name="search-input" class="form-control rounded" placeholder="Pretraga po imenu i prezimenu" aria-label="Search"
                               aria-describedby="search-addon">
                    @else
                        <input id="search-field" type="search" name="search-input" class="form-control rounded" placeholder="Pretraga po korisnickom imenu, imenu i prezimenu" aria-label="Search"
                               aria-describedby="search-addon">
                    @endif
                    <button type="submit" id="search-button" class="btn btn-outline-primary ml-1">Pretraga</button>
                </div>
            </form>
        </div>
    </div>

    <hr>

    @isset($teachers)
        <div class="row ml-5 mr-5">
            <div class="col">
                @if(count($teachers) > 0)
                    <table class="table table-striped">
                        <tr>
                            <th>#</th>
                            <th>Ime</th>
                            <th>Prezime</th>
                            <th>Korisni??ko ime</th>
                            <th>Email</th>
                            <th>Ukloni</th>
                        </tr>
                        @foreach($teachers as $teacher)
                            <tr id="{{ $teacher->user->idUser }}">
                                <td>{{ $loop->iteration.'.' }}</td>
                                <td>{{ $teacher->user->forename }}</td>
                                <td>{{ $teacher->user->surname }}</td>
                                <td>{{ $teacher->user->username }}</td>
                                <td>{{ $teacher->user->email }}</td>
                                <td>
                                    <button type="button" name="{{ $teacher->user->idUser }}" class="remove btn btn-outline-danger rounded-pill w-75" data-toggle="modal" data-target="{{ '#modal'.$teacher->user->idUser }}">&times;</button>
                                    <div class="modal fade" id="{{ 'modal'.$teacher->user->idUser }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Upozorenje!</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Da li zaista ??elite trajno da uklonite profesora?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" name="teacher" class="delete-user btn btn-danger">Ukloni profesora</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Otka??i</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <div class="alert alert-info alert-dismissible" role="alert">
{{--                        <button type="button" class="close" data-dismiss="alert">&times;</button>--}}
                        <span class="h4">Nije prona??en nijedan rezultat pretrage</span>
                    </div>
                @endif
            </div>
        </div>
    @endisset

    @isset($admins)
        <div class="row ml-5 mr-5">
            <div class="col">
                @if(count($admins) > 0)
                    <table class="table table-striped">
                        <tr>
                            <th>#</th>
                            <th>Ime</th>
                            <th>Prezime</th>
                            <th>Korisni??ko ime</th>
                            <th>Email</th>
                            <th>Ukloni</th>
                        </tr>
                        @foreach($admins as $admin)
                            <tr id="{{ $admin->user->idUser }}">
                                <td>{{ $loop->iteration.'.' }}</td>
                                <td>{{ $admin->user->forename }}</td>
                                <td>{{ $admin->user->surname }}</td>
                                <td>{{ $admin->user->username }}</td>
                                <td>{{ $admin->user->email }}</td>
                                <td>
                                    <button type="button" name="{{ $admin->user->idUser }}" class="remove btn btn-outline-danger rounded-pill w-75" data-toggle="modal" data-target="{{ '#modal'.$admin->user->idUser }}">&times;</button>
                                    <div class="modal fade" id="{{ 'modal'.$admin->user->idUser }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Upozorenje!</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Da li zaista ??elite trajno da uklonite admina?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="delete-user btn btn-danger" name="admin">Ukloni admina</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Otka??i</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <div class="alert alert-info alert-dismissible" role="alert">
{{--                        <button type="button" class="close" data-dismiss="alert">&times;</button>--}}
                        <span class="h4">Nije prona??en nijedan rezultat pretrage</span>
                    </div>
                @endif
            </div>
        </div>
    @endisset

    @isset($students)
        <div class="row ml-5 mr-5">
            <div class="col">
                @if(count($students) > 0)
                    <table class="table table-striped">
                        <tr>
                            <th>#</th>
                            <th>Ime</th>
                            <th>Prezime</th>
                            <th>Indeks</th>
                            <th>Korisni??ko ime</th>
                            <th>Email</th>
                            <th>Ukloni</th>
                        </tr>
                        @foreach($students as $student)
                            <tr id="{{ $student->user->idUser }}">
                                <td>{{ $loop->iteration.'.' }}</td>
                                <td>{{ $student->user->forename }}</td>
                                <td>{{ $student->user->surname }}</td>
                                <td>{{ $student->index }}</td>
                                <td>{{ $student->user->username }}</td>
                                <td>{{ $student->user->email }}</td>
                                <td>
                                    <button type="button" name="{{ $student->user->idUser }}" class="remove btn btn-outline-danger rounded-pill w-75" data-toggle="modal" data-target="{{ '#modal'.$student->user->idUser }}">&times;</button>
                                    <div class="modal fade" id="{{ 'modal'.$student->user->idUser }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Upozorenje!</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Da li zaista ??elite trajno da uklonite studenta?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="delete-user btn btn-danger" name="student">Ukloni studenta</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Otka??i</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <div class="alert alert-info alert-dismissible" role="alert">
{{--                        <button type="button" class="close" data-dismiss="alert">&times;</button>--}}
                        <span class="h4">Nije prona??en nijedan rezultat pretrage</span>
                    </div>
                @endif
            </div>
        </div>
    @endisset

@endsection
