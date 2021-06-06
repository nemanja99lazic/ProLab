@extends('layout/main_admin_subjects')

@section('admin_content')

    <div class="row pt-3">
        <div class="col text-center">
            <h2>{{ $subject->name }}</h2>
            <h4>({{ $subject->code }})</h4>
        </div>
    </div>
    <div class="row mt-3">
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
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $teacher->user->forename.' '.$teacher->user->surname }}</td>
                        <td>
                            <button class="btn btn-outline-danger p-1 m-0 w-75" data-toggle="modal" data-target="#modal">&times;</button>
                            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Warning!</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Da li zaista zelite trajno da obrisete profesora sa datog predmeta?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('admin.delete.teacher', [$subject->code, $teacher->idTeacher]) }}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger">Obrisi</button>
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Otkazi</button>
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
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $student->user->forename.' '.$student->user->surname }}</td>
                        <td>
                            <button class="btn btn-outline-danger p-1 m-0 w-75" data-toggle="modal" data-target="#modal">&times;</button>
                            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Warning!</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Da li zaista zelite trajno da obrisete profesora sa datog predmeta?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('admin.delete.student', [$subject->code, $student->idStudent]) }}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger">Delete</button>
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
