{{--
    Autor: Slobodan Katanic 2018/0133
--}}

@extends('layout/main_admin_subjects')

@section('admin_content')

    <div class="row mt-5 mb-3">
        <div class="col text-center">
            <h2>{{ $subject->name.' ('.$subject->code.')' }}</h2>
        </div>
    </div>
    <div class="row mt-3 ml-5 mr-5">
        <div class="col">
            <h3>Profesori:</h3>
            <table class="table">
                <tr class="thead-light">
                    <th>#</th>
                    <th>Profesor</th>
                    <th>Ukloni</th>
                </tr>
                @foreach($subject->teachers as $teacher)
                    <tr>
                        <td>{{ $loop->iteration.'.' }}</td>
                        <td>{{ $teacher->user->forename.' '.$teacher->user->surname }}</td>
                        <td>
                            <button class="btn btn-outline-danger p-1 m-0 w-75" data-toggle="modal" data-target={{'#modal'.$teacher->idTeacher}}>&times;</button>
                            <div class="modal fade" id={{'modal'.$teacher->idTeacher}} tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Upozorenje!</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Da li zaista želite trajno da obrišete profesora sa datog predmeta?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('admin.delete.teacher', [$subject->code, $teacher->idTeacher]) }}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Obriši</button>
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
        </div>
        <div class="col">
            <h3>Studenti:</h3>
            <table class="table">
                <tr class="thead-light">
                    <th>#</th>
                    <th>Student</th>
                    <th>Ukloni</th>
                </tr>
                @foreach($subject->students as $student)
                    <tr>
                        <td>{{ $loop->iteration.'.' }}</td>
                        <td>{{ $student->user->forename.' '.$student->user->surname }}</td>
                        <td>
                            <button class="btn btn-outline-danger p-1 m-0 w-75" data-toggle="modal" data-target={{'#modal'.$student->idStudent}}>&times;</button>
                            <div class="modal fade" id={{'modal'.$student->idStudent}} tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Upozorenje!</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Da li zaista želite trajno da obrišete profesora sa datog predmeta?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('admin.delete.student', [$subject->code, $student->idStudent]) }}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger">Obriši</button>
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
        </div>
    </div>

@endsection
