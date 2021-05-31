@extends('layout/main_admin_subjects')

@section('admin_content')

    <div class="row">
        <div class="col">
            {{ $project->name }}
        </div>
        <div class="col">
            {{ 'Min: '.$project->minMemberNumber }}
        </div>
        <div class="col">
            <button class="btn btn-outline-danger">Ukloni</button>
        </div>
    </div>
    @for($i = 0; $i < count($teams); $i += 2)
        <div class="row">
            <div class="col-6">
                <table>
                    <tr>
                        <th colspan="3">
                            <button class="btn btn-outline-dark">Ukloni</button>
                            <span>Otkljucan</span>
                        </th>
                        @foreach($teams[$i]->students as $student)

                        @endforeach
                    </tr>
                </table>
            </div>
            @if($i + 1 < count($teams))
                <div class="col-6">

                </div>
            @endif

        </div>
    @endfor

@endsection
