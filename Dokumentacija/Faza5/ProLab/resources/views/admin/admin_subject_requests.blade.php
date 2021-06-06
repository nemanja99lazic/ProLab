@extends('layout/main_admin')

@section('admin_content')

    <div class="row">
        <div class="col-2 mt-5 d-flex flex-column justify-content-start">
            <ul class="nav nav-pills">
                <li class="nav-item pill-request" id="pill-reg">
                    <a class="nav-link" id="v-pill-registerRequest" data-toggle="pill" href="">Registracija</a>
                </li>
                <li class="nav-item pill-request" id="pill-new">
                    <a class="nav-link active" id="v-pill-newSubjectRequest" data-toggle="pill" href="">Kreiranje predmeta</a>
                </li>
            </ul>
        </div>
        <div class="col-10 pt-5">
            @if(count($newSubjectRequests) > 0)
                <table class="table table-bordered table-striped mytable" id="subject_requests">
                    <tr>
                        <th>#</th>
                        <th>Podnosilac zahteva</th>
                        <th>Ime predmeta</th>
                        <th>Sifra predmeta</th>
                        <th class="text-center" colspan="2">Radnja</th>
                    </tr>
                    @for($i = 0; $i < count($newSubjectRequests); $i++)
                        <tr>
                            <td class="align-middle">{{ $i + 1 }}</td>
                            <td class="align-middle">{{ $newSubjectRequests[$i]->teacher->user->forename.' '.$newSubjectRequests[$i]->teacher->user->surname.' ('.$newSubjectRequests[$i]->teacher->user->email.')' }}</td>
                            <td class="align-middle">{{ explode('_', $newSubjectRequests[$i]->subjectName)[0] }}</td>
                            <td class="align-middle">{{ explode('_', $newSubjectRequests[$i]->subjectName)[1] }}</td>
                            <td class="align-middle border-right-0 text-center">
                                <button class="btn btn-outline-success p-1 m-0" data-toggle="modal" data-target="{{ '#modal1'.$newSubjectRequests[$i]->idRequest }}">Prihvati</button>
                                <div class="modal fade" id="{{ 'modal1'.$newSubjectRequests[$i]->idRequest }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Upozorenje!</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Da li zaista zelite da prihvatite zahtev za kreiranje predmeta?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('admin.addSubject') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="idRequest" id="email" value="{{ $newSubjectRequests[$i]->idRequest }}">
                                                    <button type="submit" class="btn btn-outline-success">Prihvati zahtev</button>
                                                </form>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Otkazi</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle border-left-0 text-center">
                                <button class="btn btn-outline-danger p-1 m-0" data-toggle="modal" data-target="{{ '#modal2'.$newSubjectRequests[$i]->idRequest }}">Odbij</button>
                                <div class="modal fade" id="{{ 'modal2'.$newSubjectRequests[$i]->idRequest }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Upozorenje!</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Da li zaista zelite da odbijete zahtev za kreiranje predmeta?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('admin.deleteRequest.subject') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="idRequest" id="email" value="{{ $newSubjectRequests[$i]->idRequest }}">
                                                    <button type="submit" class="btn btn-outline-danger">Odbij zahtev</button>
                                                </form>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Otkazi</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endfor
                </table>
            @else
                <div class="col mt-2">
                    <div class="row">
                        <div class="col">
                            <div class="alert alert-info alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <span class="h4">Nema zahteva kreiranje predmeta.</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
