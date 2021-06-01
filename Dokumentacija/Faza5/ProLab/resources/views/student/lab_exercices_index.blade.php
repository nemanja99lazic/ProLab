<?php //Autor: Valerijan Matvejev 2018/0257; Ispis svih labova za dati predmet ?>
@extends('layout.main')
@section('content')



    <br>
    <h3 class="font-weight-bold text-center border-bottom-12 offset-0"  >Spisak svih laboratorijskih vežbi</h3>
    <br>

    @if(Session::has('prosao'))
        <div class="row justify-content-center p-3">
            <div class="alert alert-danger alert-dismissible ">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <p >
                    <small>
                        Rok za prijavu na Lab{{Session::get('prosao')}} je prošao.
                    </small>
                </p>
            </div>
        </div>
        {{Session::forget('prosao')}}
    @endif

    <div class="row justify-content-center">
        <div class="col-6 offset-1 ">

                <table  class="table table-bordered"   >
                    <thead class="thead-light">
                    <tr>

                        <th  class="font-weight-bold text-center"  scope="col" >Aktivni labovi</th>
                        <th class="font-weight-bold text-center"scope="col">Datum i vreme isteka prijave</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($activeLabExercises as $labExercise)
                        <tr style="">


                            <td class=" text-center"><a href="{{ route('student.subject.lab.idlab.join.post',[$code,$labExercise->idLabExercise]) }}">{{$labExercise->name}}</a> </td>
                            <td class=" text-center">{{$labExercise->expiration}}</td>
                        </tr>
                    @endforeach








                    </tbody>
                </table>


        </div>
        <div class="col-5">
            <table class="table table-bordered">
                <thead class="thead-light ">
                <tr>

                    <th  class="font-weight-bold text-center"  scope="col" >Neaktivni labovi</th>
                    <th class="font-weight-bold text-center"scope="col">Datum i vreme isteka prijave</th>

                </tr>
                </thead>
                @foreach($inactiveLabExercises as $labExercise)
                    <tr style="">


                        <td class=" text-center"><a href="{{ route('student.subject.lab.idlab.join.post',[$code,$labExercise->idLabExercise]) }}">{{$labExercise->name}}</a> </td>
                        <td class=" text-center">{{$labExercise->expiration}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="row justify-content-center">
                {{$activeLabExercises->links()}}
            </div>
        </div>
        <div class="col-6">
            <div class="row justify-content-center">
                {{$inactiveLabExercises->links()}}
            </div>
        </div>
    </div>









@endsection
