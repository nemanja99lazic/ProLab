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
            <table class="table table-bordered table-striped text-center mytable" id="subject_requests">
                <tr>
                    <th>#</th>
                    <th>Submitter</th>
                    <th>Subject name</th>
                    <th>Subject code</th>
                    <th colspan="2">Action</th>
                </tr>
                @for($i = 0; $i < count($newSubjectRequests); $i++)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $newSubjectRequests[$i]->teacher->user->forename.' '.$newSubjectRequests[$i]->teacher->user->surname }}</td>
                        <td>{{ explode('_', $newSubjectRequests[$i]->subjectName)[0] }}</td>
                        <td>{{ explode('_', $newSubjectRequests[$i]->subjectName)[1] }}</td>
                        <td>
                            <form action="{{ route('admin.addSubject') }}" method="post">
                                @csrf
                                <input type="hidden" name="idRequest" value="{{ $newSubjectRequests[$i]->idRequest }}">
                                <button type="submit" class="btn btn-outline-success p-1 m-0">Accept</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('admin.deleteRequest.subject') }}" method="post">
                                @csrf
                                <input type="hidden" name="idRequest" value="{{ $newSubjectRequests[$i]->idRequest }}">
                                <button type="submit" class="btn btn-outline-danger p-1 m-0">Decline</button>
                            </form>
                        </td>
                    </tr>
                @endfor
            </table>
        </div>
    </div>

@endsection
