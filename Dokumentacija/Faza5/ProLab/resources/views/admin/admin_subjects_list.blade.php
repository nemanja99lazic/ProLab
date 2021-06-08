{{--
    Autor: Slobodan Katanic 2018/0133
--}}

@extends('layout/main_admin')

@section('admin_content')

    <div class="row ml-5 mr-5 mt-5">
        @if (count($subjects) > 0)
            <div class="col">
                <h4 class="pb-2">Spisak svih predmeta</h4>
                <table class="table table-borderless table-striped mytable" id="subject_list">
                    <tr>
                        <th>#</th>
                        <th>Naziv</th>
                        <th>Šifra</th>
                        <th>Kreator</th>
                        <th>Ukloni</th>
                    </tr>
                    @for($i = 0; $i < count($subjects); $i++)
                        <tr>
                            <td>{{ $i + 1 }}{{'.'}}</td>
                            <td><a class="my-link" href="{{ route('admin.subject.index', [$subjects[$i]->code]) }}">{{ $subjects[$i]->name }}</a></td>
                            <td>{{ $subjects[$i]->code }}</td>
                            <td>{{ $subjects[$i]->teacher->user->forename.' '.$subjects[$i]->teacher->user->surname }}</td>
                            <td class="text-center">
                                <button class="btn btn-outline-danger rounded-pill p-1 m-0 w-75" data-toggle="modal" data-target={{'#modal'.$subjects[$i]->code}}>&times;</button>
                                <div class="modal fade" id={{'modal'.$subjects[$i]->code}} tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Upozorenje!</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Da li zaista želite trajno da obrišete predmet i sve inforamcije vezane za njega?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('admin.delete.subject', [$subjects[$i]->code]) }}" method="post">
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
                    @endfor
                </table>
            </div>
        @else
            <div class="col">
                <div class="row">
                    <div class="col">
                        <div class="alert alert-info alert-dismissible" role="alert">
{{--                            <button type="button" class="close" data-dismiss="alert">&times;</button>--}}
                            <span class="h4">Ne postoji nijedan predmet.</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

@endsection
