@extends('layout/main_admin_subjects')

@section('admin_content')

    <form action="{{ route('admin.subject.lab.show', request()->subjectCode) }}" method="get">
        <div class="row pt-5 d-flex flex-row justify-content-center">
                <div class="col-3">
                    <select name="labs_list" class="form-control rounded-pill">
                        @foreach($labs as $lab)
                            <option value="{{ $lab->idLabExercise }}">
                                {{ $lab->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <button type="submit" class="btn btn-dark rounded-pill">Prikazi</button>
                </div>
        </div>
    </form>
    <div class="row">
        <div class="col">

        </div>
    </div>
@endsection
