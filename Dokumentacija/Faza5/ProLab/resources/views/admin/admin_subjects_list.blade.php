@extends('layout/main_admin')

@section('admin_content')

    <div class="row">
        <div class="col pt-5">
            <h4 class="pb-2">Available subjects</h4>
            <table class="table table-bordered table-striped mytable" id="subject_list">
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Creator</th>
                </tr>
                @for($i = 0; $i < count($subjects); $i++)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $subjects[$i]->name }}</td>
                        <td>{{ $subjects[$i]->code }}</td>
                        <td>{{ $subjects[$i]->teacher->user->forename.' '.$subjects[$i]->teacher->user->surname }}</td>
                    </tr>
                @endfor
            </table>
        </div>
    </div>

@endsection
