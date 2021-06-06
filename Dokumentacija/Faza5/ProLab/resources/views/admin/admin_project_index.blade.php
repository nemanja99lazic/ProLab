@extends('layout/main_admin_subjects')

@section('admin_content')
<form>
    @csrf
    <div class="row mt-5 d-flex flex-row justify-content-start">
        @isset($project)
            <div class="col h3 font-weight-bold">
                {{ $project->name }}
            </div>
            <div class="col h5 d-flex flex-column justify-content-center text-center">
                {{ 'Rok za prijavu: '.explode('-', $project->expirationDate)[2].'.'.explode('-', $project->expirationDate)[1].'.'.explode('-', $project->expirationDate)[0].'.' }}
            </div>
            <div class="col h5 d-flex flex-column justify-content-center text-center">
                {{ 'Min: '.$project->minMemberNumber.' | Max: '.$project->maxMemberNumber }}
            </div>
            <div class="col">
                <button type="button" class="btn btn-outline-danger rounded-pill p-1 m-0" data-toggle="modal" data-target="#modal1">Ukloni</button>
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
                                Da li zaista zelite trajno da uklonite projekat?
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger" formmethod="post" formaction="{{ route('admin.subject.project.delete', [request()->subjectCode]) }}">Ukloni projekat</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Otkazi</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col mt-0">
                <div class="row">
                    <div class="col">
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <span class="h4">Projekat nije definisan</span>
                        </div>
                    </div>
                </div>
            </div>
        @endisset
    </div>
    @isset($project)
        <hr>
    @endisset
    @isset($teams)
        @for($i = 0; $i < count($teams); $i += 2)
            <div class="row">
                <div class="col-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th colspan="3" class="text-center">
                                @if($teams[$i]->locked)
                                    <span class="mr-5">Zakljucan</span>
                                @else
                                    <span class="mr-5 font-weight-bold">Otkljucan</span>
                                @endif
                                <span class="ml-5 mr-5 h4">{{ $teams[$i]->name }}</span>
                                <button type="button" class="btn btn-outline-dark rounded-pill p-1 ml-5" data-toggle="modal" data-target="#modal2">Ukloni</button>
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
                                                Da li zaista zelite trajno da uklonite tim?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger" formmethod="post" formaction="{{ route('admin.subject.team.delete', [request()->subjectCode, $teams[$i]->idTeam]) }}">Ukloni projekat</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Otkazi</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </th>
                        <tr>
                        @foreach($teams[$i]->students as $student)
                            <tr>
                                <td>
                                    {{ $loop->iteration.'.' }}
                                </td>
                                <td>
                                    {{ $student->user->forename.' '.$student->user->surname }}
                                </td>
                                <td>
                                    {{ $student->index }}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                @if($i + 1 < count($teams))
                    <div class="col-6">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th colspan="3" class="text-center">
                                    @if($teams[$i + 1]->locked)
                                        <span class="mr-3">Zakljucan</span>
                                    @else
                                        <span class="mr-3 font-weight-bold">Otkljucan</span>
                                    @endif
                                    <button type="button" class="btn btn-outline-dark rounded-pill p-1 m-0" data-toggle="modal" data-target="#modal2">Ukloni</button>
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
                                                    Da li zaista zelite trajno da uklonite tim?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-danger" formmethod="post" formaction="{{ route('admin.subject.team.delete', [request()->subjectCode, $teams[$i + 1]->idTeam]) }}">Ukloni projekat</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Otkazi</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                            @foreach($teams[$i + 1]->students as $student)
                                <tr>
                                    <td>
                                        {{ $lopp->iteration.'.' }}
                                    </td>
                                    <td>
                                        {{ $student->user->forename.' '.$student->user->surname }}
                                    </td>
                                    <td>
                                        {{ $student->index }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @endif
            </div>
        @endfor
    @endisset
</form>
@endsection
