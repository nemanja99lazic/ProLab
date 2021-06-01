@extends('layout/main_admin')

@section('admin_content')

    <div class="row mt-3 d-flex flex-row justify-content-center">
        <div class="col-4">
            <div class="input-group">
                <form action=" {{ route('admin.users.search.results') }}" method="get">
                    Pretraga:
                    <input type="radio" name="search" value="student" id="student" checked> studenata
                    @isset($teachers)
                        <input type="radio" name="search" value="teacher" id="teacher" checked> profesora
                    @else
                        <input type="radio" name="search" value="teacher" id="teacher"> profesora
                    @endisset
                    @isset($admins)
                        <input type="radio" name="search" value="admin" id="admin" checked> admina
                    @else
                        <input type="radio" name="search" value="admin" id="admin"> admina
                    @endisset
                    <input id="search-field" type="search" name="search-input" class="form-control rounded" placeholder="Ime, prezime, broj indeksa" aria-label="Search"
                           aria-describedby="search-addon">
                    <button type="submit" id="search-button" class="btn btn-outline-info ml-1">trazi</button>
                </form>
            </div>
        </div>
    </div>


    @isset($teachers)
        <script>
            document.getElementById("search-field").value = localStorage.getItem('searchInput');
        </script>
        <div class="row">
            <div class="col">
                @if(count($teachers) > 0)
                    <table class="table table-striped">
                        <tr>
                            <th>#</th>
                            <th>Ime</th>
                            <th>Prezime</th>
                            <th>Korisnicko ime</th>
                            <th>Email</th>
                            <th>Ukloni</th>
                        </tr>
                        @foreach($teachers as $teacher)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $teacher->user->forename }}</td>
                                <td>{{ $teacher->user->surname }}</td>
                                <td>{{ $teacher->user->username }}</td>
                                <td>{{ $teacher->user->email }}</td>
                                <td>
                                    <button type="button" class="btn btn-outline-dark rounded-pill p-1 ml-5" data-toggle="modal" data-target="#modal1">&times;</button>
                                    <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Upozorenje!</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Da li zaista zelite trajno da uklonite profesora?
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('admin.users.delete.teacher', [$teacher->user->idUser]) }}" method="post">
                                                        <button type="submit" class="btn btn-danger">Ukloni profesora</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Otkazi</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <span class="h4">Nije pronadjen nijedan rezultat pretrage</span>
                    </div>
                @endif
            </div>
        </div>
    @endisset

    @isset($admins)
        <script>
            document.getElementById("search-field").value = localStorage.getItem('searchInput');
        </script>
        <div class="row">
            <div class="col">
                @if(count($admins) > 0)
                    <table class="table table-striped">
                        <tr>
                            <th>#</th>
                            <th>Ime</th>
                            <th>Prezime</th>
                            <th>Korisnicko ime</th>
                            <th>Email</th>
                            <th>Ukloni</th>
                        </tr>
                        @foreach($admins as $admin)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $admin->user->forename }}</td>
                                <td>{{ $admin->user->surname }}</td>
                                <td>{{ $admin->user->username }}</td>
                                <td>{{ $admin->user->email }}</td>
                                <td>
                                    <button type="button" class="btn btn-outline-dark rounded-pill p-1 ml-5" data-toggle="modal" data-target="#modal2">&times;</button>
                                    <div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Upozorenje!</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Da li zaista zelite trajno da uklonite admina?
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('admin.users.delete.admin', [$admin->user->idUser]) }}" method="post">
                                                        <button type="submit" class="btn btn-danger">Ukloni admina</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Otkazi</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <div class="alert alert-success alesrt-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <span class="h4">Nije pronadjen nijedan rezultat pretrage</span>
                    </div>
                @endif
            </div>
        </div>
    @endisset

    @isset($students)
        <script>
            document.getElementById("search-field").value = localStorage.getItem('searchInput');
        </script>
        <div class="row">
            <div class="col">
                @if(count($students) > 0)
                    <table class="table table-striped">
                        <tr>
                            <th>#</th>
                            <th>Ime</th>
                            <th>Prezime</th>
                            <th>Indeks</th>
                            <th>Korisnicko ime</th>
                            <th>Email</th>
                            <th>Ukloni</th>
                        </tr>
                        @foreach($students as $student)
                            <tr id="{{ $student->user->idUser }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $student->user->forename }}</td>
                                <td>{{ $student->user->surname }}</td>
                                <td>{{ $student->index }}</td>
                                <td>{{ $student->user->username }}</td>
                                <td>{{ $student->user->email }}</td>
                                <td>
                                    <button type="button" name="{{ $student->user->idUser }}" class="remove btn btn-outline-dark rounded-pill p-1 ml-5" data-toggle="modal" data-target="{{ '#modal'.$student->user->idUser }}">&times;</button>
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
                                                    Da li zaista zelite trajno da uklonite studenta?
                                                </div>
                                                <div class="modal-footer">
{{--                                                    <form action="{{ route('admin.users.delete.student', [$student->user->idUser]) }}" method="post">--}}
{{--                                                        <button type="submit" class="btn btn-danger">Ukloni studenta</button>--}}
{{--                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Otkazi</button>--}}
{{--                                                    </form>--}}
                                                    <button type="button" class="delete-student btn btn-danger" name="{{ $student->user->idUser }}">Ukloni studenta</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Otkazi</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <div class="alert alert-success alesrt-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <span class="h4">Nije pronadjen nijedan rezultat pretrage</span>
                    </div>
                @endif
            </div>
        </div>
    @endisset

@endsection
