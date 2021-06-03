<?php //Autor1: Valerijan Matvejev 2018/0257, Autor2: Nemanja Lazic 2018/0004; Ispis svih labova za dati predmet ?>
@extends('layout.main')
@section('content')

    <link rel="stylesheet" href="{{asset("css/teacher/show_labs_style.css")}}">
    <script src="{{asset("js/teacher/show_labs_script.js")}}"></script>

    <br>
    <h3 class="font-weight-bold text-center border-bottom-12 offset-0"  >Spisak laboratorijskih vežbi</h3>
    <br>

    <div class="row justify-content-center">
        <div class="col-auto">
            <table  class="table table-bordered"  style="width: 80vh;" >
                <thead class="thead-light">
                    <tr>
                        <th  class="font-weight-bold text-center"  scope="col" >Aktivni labovi</th>
                        <th class="font-weight-bold text-center"scope="col">Datum i vreme isteka prijave</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($labExercises as $labExercise)
                        <tr style="">
                            <td class=" text-center"><a href="{{ route('teacher.showLabAppointments', [$code,$labExercise->idLabExercise]) }}">{{$labExercise->name}}</a></td>
                            <td class=" text-center">{{$labExercise->expiration}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-auto">
            <button class="kreiraj-lab" id="btn-kreiraj-lab" data-code={{$code}}>+</button>
            <label class="kreiraj-lab" id="label-kreiraj-lab">Kreiraj laboratorijsku vežbu</label>
        </div>
    </div>
    <div class="row justify-content-center">
        {{$labExercises->links()}}
    </div>

@endsection
