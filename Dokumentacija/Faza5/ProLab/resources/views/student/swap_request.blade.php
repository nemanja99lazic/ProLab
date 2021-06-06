<?php //Autor: Valerijan Matvejev 2018/0257; Prikaz za unos zahteva za zamenu ?>
@extends('layout.student_main')

@section('page-nav')
    <input hidden value="{{ request()->code }}" id="sifraPredmeta">
    <input hidden value="{{ request()->idLab }}" id="sifraLaba">

    <a class="project-tab-button  nav-item ml-3 mr-1 nav-link btn-outline-dark {{ request()->is('student/subject/*/index')  ? 'active' : ''}}" id="nav-subject-tab" data-toggle="tab" href="" role="tab" aria-controls="nav-home" aria-selected="true" style="font-size: medium">Stranica predmeta</a>
    <a class="project-tab-button  nav-item mr-1 nav-link btn-outline-dark {{ request()->is('student/subject/*/lab') || request()->is('student/subject/*/lab/*') ? 'active' : ''}}" id="nav-lab-tab" data-toggle="tab" href="" role="tab" aria-controls="nav-profile" aria-selected="false"style="font-size: medium" >Laboratorijske vežbe</a>
    <a class="project-tab-button  nav-item mr-1 nav-link btn-outline-dark {{ request()->is('student/subject/*/project')  ? 'active' : ''}}" id="nav-project-tab" data-toggle="tab" href="" role="tab" aria-controls="nav-contact" aria-selected="false"style="font-size: medium" >Projekat</a>

@endsection
@section('content')

    <script src="{{ asset('js/app.js') }}" defer></script>


    <div class="col-5 mt-5 d-flex flex-column justify-content-start">
        <ul class="nav nav-pills ml-5">
            <li class="nav-item pill-request" id="pill-reg">
                <a class="nav-link " id="v-pill-joinAppointment" data-toggle="pill" href="">Prijava/odjava termina</a>
            </li>
            <li class="nav-item pill-request" id="pill-new">
                <a class="nav-link " id="v-pill-swapAppointments" data-toggle="pill" href="">Zamena termina</a>
            </li>
            <li class="nav-item pill-request" id="pill-new">
                <a class="nav-link active " id="v-pill-swapRequest" data-toggle="pill" href="" >Zahtev za zamenu</a>
            </li>
        </ul>
    </div>


    <div class="row justify-content-center">
        <h2 class="font-weight-bold  text-center border-bottom-12 offset-0 p-5 m-1"  >
            Odaberite željeni (željene) termine:
        </h2>

    </div>
    <form action="{{ route('student.subject.code.lab.idlab.request.post',[$code,$lab]) }}" method="post">
    @csrf
        <div class="row justify-content-center">

            <div class="col-6">

                <table  class="table table-bordered m-auto " style="width: 80vh" >
                    <thead class="thead-light" >
                    <tr>
                        <th  class="text-center" style="width: auto" >
                            <h2 >
                                <small class="font-weight-bold  text-center">

                                </small>
                            </h2>
                        </th>
                        <th  class="text-center" style="width: auto" >
                            <h2 >
                                <small class="font-weight-bold  text-center">
                                    Datum
                                </small>
                            </h2>
                        </th>
                        <th  class="text-center" >
                            <h2 >
                                <small class="font-weight-bold  text-center">
                                    Vreme
                                </small>
                            </h2>
                        </th>
                        <th  class="text-center" >
                            <h2 >
                                <small class="font-weight-bold  text-center">
                                    Sala
                                </small>
                            </h2>
                        </th>




                    </tr>
                    </thead>



                    <tbody>

                    @foreach($appointments as $appointment)

                        <tr class="text-center">
                            <td >
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="zahtevi" name="zahtevi[]"
                                           value="{{$myAppointment.",".Session::get('user')['userObject']->idUser
                                                .",".explode(',',$appointment)[3]}}"
                                           >

                                </div>
                            </td>

                            <td class="text-center">
                                {{explode(',',$appointment)[0]}}
                            </td>
                            <td class="text-center">

                                {{explode(',',$appointment)[1]}}

                            </td>
                            <td class="text-center">
                                {{explode(',',$appointment)[2]}}
                            </td>




                        </tr>


                    @endforeach

                    </tbody>

                </table>

            </div>






        </div>


        <div class="row justify-content-center pt-4">
            {{$appointments->links()}}
        </div>
        <div class="row justify-content-center p-5">
            <button
                type="submit" class="btn-lg btn-outline-info  " id="btn-kreiranje-zahteva"
            >Potvrdi
            </button>
        </div>
    </form>
@endsection
