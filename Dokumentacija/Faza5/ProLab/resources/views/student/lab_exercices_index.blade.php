<?php //Autor: Valerijan Matvejev 2018/0257; Ispis svih labova za dati predmet ?>
@extends('layout.student_main')
@section("page-title")
     Spisak labova
@endsection

@section('page-nav')
    <input hidden value="{{ request()->code }}" id="sifraPredmeta">
    <input hidden value="{{ request()->idLab }}" id="sifraLaba">

    <a class="project-tab-button  nav-item ml-3 mr-1 nav-link btn-outline-dark {{ request()->is('student/subject/*/index')  ? 'active' : ''}}" id="nav-subject-tab" data-toggle="tab" href="" role="tab" aria-controls="nav-home" aria-selected="true" style="font-size: medium">Stranica predmeta</a>
    <a class="project-tab-button  nav-item mr-1 nav-link btn-outline-dark {{ request()->is('student/subject/*/lab') || request()->is('student/subject/*/lab/*') ? 'active' : ''}}" id="nav-lab-tab" data-toggle="tab" href="" role="tab" aria-controls="nav-profile" aria-selected="false"style="font-size: medium" >Laboratorijske vežbe</a>
    <a class="project-tab-button  nav-item mr-1 nav-link btn-outline-dark {{ request()->is('student/subject/*/project')  ? 'active' : ''}}" id="nav-project-tab" data-toggle="tab" href="" role="tab" aria-controls="nav-contact" aria-selected="false"style="font-size: medium" >Projekat</a>

@endsection

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
                        Rok za prijavu na {{Session::get('prosao')}} je prošao.
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




