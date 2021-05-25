<?php //Autor: Valerijan Matvejev 2018/0257; Ispis svih labova za dati predmet ?>
@extends('layout.main')
@section('content')


    <script src="{{ asset('js/navbar.js') }}" defer></script>
    <br>
    <h3 class="font-weight-bold text-center border-bottom-12 offset-0"  >Spisak aktivnih labova</h3>
    <br>
    <div class="row justify-content-center">
        <div class="col-auto">

                <table id="dtDynamicVerticalScrollExample" class="table table-bordered " style="width: 80vh" >
                    <thead class="thead-light">
                    <tr>

                        <th  class="font-weight-bold text-center" style="width: 50%" scope="col" >Aktivni labovi</th>
                        <th class="font-weight-bold text-center" style="width: 50%"scope="col">Datum i vreme isteka prijave</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($labExercises as $labExercise)
                        <tr style="">


                            <td class=" text-center"><a href="{{ route('student.subject.lab.idlab.join.post',[$code,$labExercise->idLabExercise]) }}">{{$labExercise->name}}</a> </td>
                            <td class=" text-center">{{$labExercise->expiration}}</td>
                        </tr>
                    @endforeach

                    <tr style="">


                        <td class=" text-center">A </td>
                        <td class=" text-center">B</td>
                    </tr>






                    </tbody>
                </table>


        </div>
    </div>






@endsection
