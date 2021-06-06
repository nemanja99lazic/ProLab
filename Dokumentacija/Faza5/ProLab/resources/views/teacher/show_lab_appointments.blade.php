<!-- Prikaz lab vezbe sa odgovarajucim terminima 
    Nemanja Lazic 2018/0004
-->

@extends('layout.profesor.main_stranica_predmeta')
@section('page-title')
    Termini laboratorijske vežbe
@endsection
@section('content')
    <br>
    <div class="row justify-content-center">
        <h2 class="font-weight-bold  text-center border-bottom-12 offset-0"  >Ponuđeni termini za {{$lab->name}}</h2>
    </div>
    <div class="row justify-content-center">
        <button class='btn btn-info justify-content-center' disabled>
            <p class='mt-auto'>
                Rok za prijavu: {{$lab->expiration->format('d.m.Y, H:i')}}
            </p>
        </button>
    </div>
    <br>
    <!-- 'd.m.Y H:i' -->
    <div class="row justify-content-center">
        @foreach ($appointments as $appointment)
            <div class="col-12 col-md-6" style="margin-bottom: 50px">
                <table class="table table-striped table-bordered m-auto" style="width: 80vh;">                    
                        <tr>
                            <th colspan="3">
                                <h2 class="text-center font-weight-bold">{{date('d.m.Y H:i', strtotime($appointment['datetime'])). ", " .$appointment['location']}}</h2>
                            </th>
                        </tr>
                        @foreach ($appointment['students'] as $student)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$student['forename']. " " .$student['surname']}}</td>
                                <td>{{$student['index']}}</td>
                            </tr>
                        @endforeach
                </table>
            </div>
        @endforeach
    </div>
    <div class="row justify-content-center">
            {{$appointments->links()}}
    </div>
    <div class="row justify-content-center">
        <form action={{"/teacher/subject/". $code ."/lab"}} method="get">
            <input type="submit" value="Nazad na spisak lab vežbi" class="btn btn-outline-secondary">
        </form>
    </div>
@endsection