@extends('layout/main_admin_subjects')

@section('admin_content')

{{--    <form action="{{ route('admin.subject.lab.show', request()->subjectCode) }}" method="get">--}}
    <form>
        @csrf
        <div class="row pt-5 d-flex flex-row justify-content-center">
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
                <button type="submit" class="btn btn-dark rounded-pill" formaction="{{ route('admin.subject.lab.show', request()->subjectCode) }}" formmethod="get">Prikazi</button>
            </div>
            @isset($lab)
                <div class="col-4 offset-1 h4">
                    {{ 'Rok za prijavu: '.$lab->expiration->format('j.m. G:i').'h' }}
                </div>
                <div class="col-1 offset-2">
                    <button type="button" class="btn btn-outline-danger p-1 m-0 rounded-pill" data-toggle="modal" data-target="#modal1">Ukloni</button>
                    <div class="modal fade" id="modal1" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Warning!</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Da li zaista zelite trajno da obrisete laboratorijsku vezbu?
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-dark rounded-pill" formmethod="post" formaction="{{ route('admin.subject.lab.delete', [request()->subjectCode]) }}">Ukloni</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
                                    <span class="mr-3">{{ 'Odrzavanje: '.$lab->appointments[$i]->datetime->format('j.m. G:i').'h, sala '.$lab->appointments[$i]->classroom }}</span>
                                    <button type="button" class="btn btn-outline-dark p-1 mr-3 rounded-pill" data-toggle="modal" data-target="#modal2">Ukloni</button>
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
                                                    Da li zaista zelite trajno da uklonite termin?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-dark rounded-pill" formmethod="post" formaction="{{ route('admin.subject.lab.app.delete', [request()->subjectCode, $lab->appointments[$i]->idAppointment]) }}">Ukloni termin</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
                                        <button type="button" class="btn btn-outline-dark rounded-pill p-1 m-0" data-toggle="modal" data-target="#modal3">Ukloni</button>
                                        <div class="modal fade" id="modal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Upozorenje!</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Da li zaista zelite trajno da uklonite termin?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-dark rounded-pill" formmethod="post" formaction="{{ route('admin.subject.lab.app.delete', [request()->subjectCode, $lab->appointments[$i + 1]->idAppointment]) }}">Ukloni termin</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
