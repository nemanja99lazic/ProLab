{{--
    Autor: Slobodan Katanic 2018/0133
--}}
@extends('layout/main_admin')

@section('admin_content')

    <div class="row">
        <div class="col pt-5">
            <h4 class="pb-2">Spisak svih predmeta</h4>
            <table class="table table-bordered table-striped mytable" id="subject_list">
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Creator</th>
                    <th>Remove</th>
                </tr>
                @for($i = 0; $i < count($subjects); $i++)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><a href="{{ route('admin.subject.index', [$subjects[$i]->code]) }}">{{ $subjects[$i]->name }}</a></td>
                        <td>{{ $subjects[$i]->code }}</td>
                        <td>{{ $subjects[$i]->teacher->user->forename.' '.$subjects[$i]->teacher->user->surname }}</td>
                        <td class="text-center">
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
                                            Da li zaista zelite trajno da obrisete predmet i sve inforamcije vezane za njega?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('admin.delete.subject', [$subjects[$i]->code]) }}" method="post">
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
                @endfor
            </table>
        </div>
    </div>

@endsection
