<?php //Autor: Valerijan Matvejev 2018/0257; Prikaz mogućih studenata za zamenu ?>
@extends('layout.student_main')
@section("page-title")
    Spisak termina za zamenu
@endsection

@section('page-nav')
    <input hidden value="{{ request()->code }}" id="sifraPredmeta">
    <input hidden value="{{ request()->idLab }}" id="sifraLaba">

    <a class="project-tab-button  nav-item ml-3 mr-1 nav-link btn-outline-dark {{ request()->is('student/subject/*/index')  ? 'active' : ''}}" id="nav-subject-tab" data-toggle="tab" href="" role="tab" aria-controls="nav-home" aria-selected="true" style="font-size: medium">Stranica predmeta</a>
    <a class="project-tab-button  nav-item mr-1 nav-link btn-outline-dark {{ request()->is('student/subject/*/lab') || request()->is('student/subject/*/lab/*') ? 'active' : ''}}" id="nav-lab-tab" data-toggle="tab" href="" role="tab" aria-controls="nav-profile" aria-selected="false"style="font-size: medium" >Laboratorijske vežbe</a>
    <a class="project-tab-button  nav-item mr-1 nav-link btn-outline-dark {{ request()->is('student/subject/*/project')  ? 'active' : ''}}" id="nav-project-tab" data-toggle="tab" href="" role="tab" aria-controls="nav-contact" aria-selected="false"style="font-size: medium" >Projekat</a>

@endsection

@section('content')


    <div class="col-5 mt-5 d-flex flex-column justify-content-start">
        <ul class="nav nav-pills ml-5">
            <li class="nav-item pill-request" id="pill-reg">
                <a class="nav-link " id="v-pill-joinAppointment" data-toggle="pill" href="">Prijava/odjava termina</a>
            </li>
            <li class="nav-item pill-request" id="pill-new">
                <a class="nav-link active" id="v-pill-swapAppointments" data-toggle="pill" href="">Zamena termina</a>
            </li>
            <li class="nav-item pill-request" id="pill-new">
                <a class="nav-link " id="v-pill-swapRequest" data-toggle="pill" href="">Zahtev za zamenu</a>
            </li>
        </ul>
    </div>

    @if(Session::has('nemaTermina'))
        <div class="row justify-content-center">
            <div class="jumbotron justify-content-center" style="width: 40vh; height: 10vh; background: none">

                <div class="row justify-content-center" style="font-size: x-large">
                    Nema termina za ovaj lab.
                </div>
                <div class="row ">
                    <button class="btn btn-info btn-sm hBack" style="font-size: medium" type="button"> <- Povratak na prethodnu stranu </button>
                </div>

            </div>
        </div>
        {{Session::forget('nemaTermina')}}
    @endif

    <div class="row justify-content-center">

        <h2 class="font-weight-bold  text-center border-bottom-12 offset-0 p-5 m-1"  >
            Izaberite sa kime biste želeli da zamenite termin:
        </h2>

    </div>

    <form action="{{ route('student.subject.code.lab.idlab.swap.post',[$code,$lab]) }}" method="post">
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
                                   Ime, prezime i broj indeksa
                                </small>
                            </h2>
                        </th>
                        <th  class="text-center" >
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

                    @foreach($datas as $data)

                        <tr class="text-center">
                            <td >
                                <div class="form-check">

                                         <input class=" form-check-input" style="width: 20px; height: 20px" type="radio"
                                           name="odabrani" id="odabrani"
                                           value="{{$myAppointment.",".Session::get('user')['userObject']->idUser
                                                .",".explode(',',$data)[4].",".explode(',',$data)[5]}}">

                                </div>
                            </td>

                            <td class="text-center">
                                {{explode(',',$data)[0]}}
                            </td>
                            <td class="text-center">

                                {{explode(',',$data)[1]}}

                            </td>
                            <td class="text-center">
                                {{explode(',',$data)[2]}}
                            </td>
                            <td class="text-center">
                                {{explode(',',$data)[3]}}
                            </td>



                        </tr>


                    @endforeach

                    </tbody>

                </table>

            </div>






    </div>
        <div class="row justify-content-center pt-4">
            {{$datas->links()}}
        </div>
    <div class="row justify-content-center p-5">
            <button
                type="submit" class="btn-lg btn-outline-info  "
            >Potvrdi
            </button>
    </div>
    </form>





@endsection
