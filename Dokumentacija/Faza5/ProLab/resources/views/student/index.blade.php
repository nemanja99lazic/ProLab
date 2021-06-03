<!-- Student index strana
    - Nemanja Lazic 2018/0004
-->


@extends('layout.main')
@section('content')

    <link rel="stylesheet" href="{{asset('css/student/index_style.css')}}">
    <script src="{{asset('js/student/index_script.js')}}"></script>

    <div class="row">
        <div class="col-md-2" id="prazno-1"></div>
        <div class="col-xs-12 col-md-4 levo">
            <table class="table table-borderless" id='table-student-info'>
                <tr>
                    <td><label for="" id="label-email">E-mail:</label></td>
                    <td class="info"><label for="">{{$email}}</label></td>
                </tr>
                <tr>
                    <td><label for="" id="label-index">Broj indeksa:</label></td>
                    <td class="info">{{$index}}</td>
                </tr>
            </table>
        </div>
        <div class="col-xs-12 col-md-4 desno">
            <h1 id="desno-ime-prezime">{{$forename}} {{$surname}}</h1>
            <h4 id="natpis-student">Student</h4>
            <div id="student-circle-inicijali"></div>
        </div>
        <div class="col-md-2" id="prazno-2"></div>
    </div>
@endsection