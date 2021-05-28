@extends('layout/main_admin')

@section('admin_content')

    <div class="row">
        <div class="col-2 mt-5 d-flex flex-column justify-content-start">
            <div class="nav flex-column nav-pills" id="v-pills" role="tablist" aria-orientation="vertical">
                <a class="nav-link" id="v-pill-registerRequest" data-toggle="pill" role="tab" aria-controls="v-pills-home" aria-selected="true" href="">Registration requests</a>
                <a class="nav-link active" id="v-pill-newSubjectRequest" data-toggle="pill" href="" role="tab" aria-controls="v-pills-profile" aria-selected="false">New subject requests</a>
            </div>
        </div>
        <div class="col-10 pt-5">
            <table class="table table-bordered table-striped text-center mytable" id="subject_requests">
                <tr>
                    <th>No.</th>
                    <th>Submitter</th>
                    <th>Subject name</th>
                    <th colspan="2">Action</th>
                </tr>
                @for($i = 0; $i < count($newSubjectRequests); $i++)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $newSubjectRequests[$i]->teacher->user->forename.' '.$newSubjectRequests[$i]->teacher->user->surname }}</td>
                        <td>{{ $newSubjectRequests[$i]->subjectName }}</td>
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
