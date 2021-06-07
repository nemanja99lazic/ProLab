{{--
    Autor: Slobodan Katanic 2018/0133
--}}

@extends('layout/main_admin_subjects')

@section('admin_content')

{{--    <form action="{{ route('admin.subject.lab.show', request()->subjectCode) }}" method="get">--}}
    <form>
        @csrf
        <div class="row mt-5 d-flex flex-row justify-content-center ml-5 mr-5">
            @if(count($labs) > 0)
                <div class="col-3">
                    <select name="labs_list" class="form-control rounded-pill">
                        @foreach($labs as $labE)
                            @if(isset($idLab) && $idLab == ($labE->idLabExercise))
                                <option value="{{ $labE->idLabExercise }}" selected>
                                    {{ $labE->name }}
                                </option>
                            @else
                                <option value="{{ $labE->idLabExercise }}">
                                    {{ $labE->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-1">
                    <button type="submit" class="btn btn-dark rounded-pill" formaction="{{ route('admin.subject.lab.show', request()->subjectCode) }}" formmethod="get">Prikaži</button>
                </div>
            @else
                <div class="col mt-0">
                    <div class="row">
                        <div class="col">
                            <div class="alert alert-info alert-dismissible" role="alert">
                                <span class="h4">Trenutno nema nijedne laboratorijske vežbe</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @isset($lab)
                <div class="col-4 offset-1 h4">
                    {{ 'Rok za prijavu: '.$lab->expiration->format('j.m. G:i').'h' }}
                </div>
                <div class="col-1 offset-2">
                    <button type="button" class="btn btn-outline-danger p-1 m-0 rounded-pill" data-toggle="modal" data-target="#modalHeader">Ukloni</button>
                    <div class="modal fade" id="modalHeader" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Upozorenje!</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Da li zaista želite trajno da obrišete laboratorijsku vežbu?
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger" formmethod="post" formaction="{{ route('admin.subject.lab.delete', [request()->subjectCode]) }}">Ukloni</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Otkaži</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endisset
        </div>
{{--    </form>--}}
        @isset($lab)
            @for($i = 0; $i < count($lab->appointments); $i += 2)
                <div class="row mt-4">
                    <div class="col-6">
                        <table class="table table-bordered table-hover table-striped">
                            <tr class="text-center">
                                <th colspan="3">
                                    <span class="mr-3">{{ 'Održavanje: '.$lab->appointments[$i]->datetime->format('j.m. G:i').'h, sala '.$lab->appointments[$i]->classroom }}</span>
                                    <button type="button" class="btn btn-outline-dark p-1 mr-3 rounded-pill" data-toggle="modal" data-target={{'#modal'.$lab->appointments[$i]->idAppointment}}>Ukloni</button>
                                    <div class="modal fade" id={{'modal'.$lab->appointments[$i]->idAppointment}} tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Upozorenje!</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Da li zaista želite trajno da uklonite termin?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-danger" formmethod="post" formaction="{{ route('admin.subject.lab.app.delete', [request()->subjectCode, $lab->appointments[$i]->idAppointment]) }}">Ukloni termin</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Otkaži</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                            @foreach($lab->appointments[$i]->hasAppointments as $hasApp)
                                <tr>
                                    <td>{{ $loop->iteration.'.' }}</td>
                                    <td>{{ $hasApp->student->user->forename.' '.$hasApp->student->user->surname}}</td>
                                    <td>{{ $hasApp->student->index }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    @if($i + 1 < count($lab->appointments))
                        <div class="col-6">
                            <table class="table table-bordered table-hover table-striped">
                                <tr class="text-center">
                                    <th colspan="3">
                                        <span class="mr-3">{{ 'Odrzavanje: '.$lab->appointments[$i + 1]->datetime->format('j.m. G:i').'h, sala '.$lab->appointments[$i + 1]->classroom }}</span>
                                        <button type="button" class="btn btn-outline-dark rounded-pill p-1 m-0" data-toggle="modal" data-target={{'#modal'.$lab->appointments[$i + 1]->idAppointment}}>Ukloni</button>
                                        <div class="modal fade" id={{'modal'.$lab->appointments[$i + 1]->idAppointment}} tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Upozorenje!</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Da li zaista želite trajno da uklonite termin?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-danger" formmethod="post" formaction="{{ route('admin.subject.lab.app.delete', [request()->subjectCode, $lab->appointments[$i + 1]->idAppointment]) }}">Ukloni termin</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Otkaži</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                                @foreach($lab->appointments[$i + 1]->hasAppointments as $hasApp)
                                    <tr>
                                        <td>{{ $loop->iteration.'.' }}</td>
                                        <td>{{ $hasApp->student->user->forename.' '.$hasApp->student->user->surname}}</td>
                                        <td>{{ $hasApp->student->index }}</td>
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
