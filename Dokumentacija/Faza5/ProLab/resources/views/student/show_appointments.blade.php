<?php //Autor: Valerijan Matvejev 2018/0257; Prikaz svih termina za dati lab ?>
@extends('layout.student_main')
@section("page-title")
    Spisak termina za dati lab
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
                <a class="nav-link active" id="v-pill-joinAppointment" data-toggle="pill" href="">Prijava/odjava termina</a>
            </li>
            <li class="nav-item pill-request" id="pill-new">
                <a class="nav-link" id="v-pill-swapAppointments" data-toggle="pill" href="">Zamena termina</a>
            </li>
        </ul>
    </div>



    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/student/show_appointments_script.js') }}" defer></script>
    <link rel="stylesheet" href="{{asset('css/student/show_appointments_style.css')}}">


    <br>
            <div class="row justify-content-center">
                <h2 class="font-weight-bold  text-center border-bottom-12 offset-0"  >Ponuđeni termini za {{$lab->name}}</h2>

            </div>

            <div class="row justify-content-center">
                <button class='btn btn-info justify-content-center' disabled>
                    <p>
                        Rok za prijavu: {{$lab->expiration->format('d.m.Y, H:i')}}
                    </p>
                </button>
            </div>

    <br>


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
    @if(Session::has('nePosedujemTermin'))
        <div class="row justify-content-center p-3">
            <div class="alert alert-danger alert-dismissible ">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <p >
                    <small>
                        Ne možete uraditi zamenu ako niste prijavljeni na neki termin.
                    </small>
                </p>
            </div>
        </div>
        {{Session::forget('nePosedujemTermin')}}
    @endif
    @if(Session::has('swapZavrsen'))
        <div class="row justify-content-center p-3">
            <div class="alert alert-success alert-dismissible ">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <p >
                    <small>
                        Uspešno izvršena zamena termina.
                    </small>
                </p>
            </div>
        </div>
        {{Session::forget('swapZavrsen')}}
    @endif
    @if(Session::has('zahtevEvidentiran'))
        <div class="row justify-content-center p-3">
            <div class="alert alert-success alert-dismissible ">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <p >
                    <small>
                        Uspešno evidentiran zahtev za zamenu.
                    </small>
                </p>
            </div>
        </div>
        {{Session::forget('zahtevEvidentiran')}}
    @endif

    @for ($i = 0; $i < count($appointments);$i+=2 )
        <div class="row p-3">

            @if(($i)<count($appointments))
                <div class="col-6 ">

                    <table  class="table table-bordered m-auto " style="width: 80vh" >
                        <thead class="thead-light" >
                        <tr>

                            <th  class="text-center" scope="col" colspan="3" >
                                <h2 >
                                    <small class="font-weight-bold  text-center">
                                        {{$appointments[$i]->datetime->format('d.m.Y, H:i')." , ".$appointments[$i]->classroom}}
                                    </small>
                                </h2>


                                <div class="d-flex justify-content-center">
                                    <form action="{{ route('student.subject.lab.idlab.join.post',[$code,$lab->idLabExercise]) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="idAppointment" id="idAppointment" value="{{$appointments[$i]->idAppointment}}">
                                        <input type="hidden" name="iteracija" value="{{$i}}">
                                        <button
                                            type="submit" class="btn btn-secondary p-1 m-1" about="{{Session::get('greska')}}" id="btn-termin-prijava"
                                            @foreach($array as $a)
                                                @if(explode(',',$a)[3]!=$appointments[$i]->idAppointment)
                                                    @continue
                                                @endif

                                                @if(explode(',',$a)[4]!=\Illuminate\Support\Facades\Session::get('user')['userObject']->idUser)
                                                    @continue
                                                @endif
                                                disabled

                                                @break
                                            @endforeach

                                        >Prijavi se
                                        </button>
                                    </form>
                                    <br>
                                    <form action="{{ route('student.subject.lab.idlab.leave',[$code,$lab->idLabExercise]) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="idAppointment" id="idAppointment" value="{{$appointments[$i]->idAppointment}}">

                                        <button
                                            type="submit" class="btn btn-danger p-1 m-1"

                                            @if($empty==true || !($IAmInThisOne==$appointments[$i]))
                                            disabled
                                            @endif
                                        >Odjavi se
                                        </button>

                                    </form>
                                </div>




                            </th>


                        </tr>
                        </thead>

                        <tbody>
                        @foreach($array as $a)
                            @if(explode(',',$a)[3]!=$appointments[$i]->idAppointment)
                                @continue
                            @endif
                            <tr style="">


                                <td class=" text-center" style="width: 20%">{{$redniBrojevi[$i]++}} </td>
                                <td class=" text-center" style="width: 40%">{{explode(',',$a)[0]." ".explode(',',$a)[1]}} </td>
                                <td class=" text-center" style="width: 40%">{{explode(',',$a)[2]}} </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>


                    @if(Session::get('kapacitet')==($i+1))
                        <div class="row justify-content-center p-3">
                            <div class="alert alert-danger alert-dismissible ">
                                <button type="button" class="close" data-dismiss="alert">x</button>
                                <p >
                                    <small>Termin je popunjen. Potražite ostale termine.
                                    </small>
                                </p>
                            </div>
                        </div>
                        {{Session::forget('kapacitet')}}
                    @endif
                </div>

                @endif
            @if(($i+1)<count($appointments))
                <div class="col-6">

                    <table class="table table-bordered m-auto " style="width: 80vh" >
                        <thead class="thead-light" >
                        <tr>

                            <th  class="text-center" scope="col" colspan="3" >
                                <h2 >
                                    <small class="font-weight-bold  text-center">
                                        {{$appointments[$i+1]->datetime->format('d.m.Y, H:i')." , ".$appointments[$i+1]->classroom}}
                                    </small>
                                </h2>


                                <div class="d-flex justify-content-center">
                                    <form action="{{ route('student.subject.lab.idlab.join.post',[$code,$lab->idLabExercise]) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="idAppointment" id="idAppointment" value="{{$appointments[$i+1]->idAppointment}}">
                                        <input type="hidden" name="iteracija" value="{{$i+1}}">
                                        <button
                                            type="submit" class="btn btn-secondary p-1 m-1" id="btn-termin-prijava"
                                            @foreach($array as $a)
                                            @if(explode(',',$a)[3]!=$appointments[$i+1]->idAppointment)
                                            @continue
                                            @endif

                                            @if(explode(',',$a)[4]!=\Illuminate\Support\Facades\Session::get('user')['userObject']->idUser)
                                            @continue
                                            @endif
                                            disabled

                                            @break
                                            @endforeach

                                        >Prijavi se
                                        </button>
                                    </form>
                                    <br>
                                    <form action="{{ route('student.subject.lab.idlab.leave',[$code,$lab->idLabExercise]) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="idAppointment" id="idAppointment" value="{{$appointments[$i+1]->idAppointment}}">

                                        <button
                                            type="submit" class="btn btn-danger p-1 m-1"

                                            @if($empty==true || !($IAmInThisOne==$appointments[$i+1]))
                                            disabled
                                            @endif
                                        >Odjavi se
                                        </button>

                                    </form>
                                </div>




                            </th>


                        </tr>
                        </thead>

                        <tbody>
                        @foreach($array as $a)
                            @if(explode(',',$a)[3]!=$appointments[$i+1]->idAppointment)
                                @continue
                            @endif
                            <tr style="">


                                <td class=" text-center" style="width: 20%">{{$redniBrojevi[$i+1]++}} </td>
                                <td class=" text-center" style="width: 40%">{{explode(',',$a)[0]." ".explode(',',$a)[1]}} </td>
                                <td class=" text-center" style="width: 40%">{{explode(',',$a)[2]}} </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                    @if(Session::get('kapacitet')==($i+2))
                        <div class="row justify-content-center p-3">
                            <div class="alert alert-danger alert-dismissible ">
                                <button type="button" class="close" data-dismiss="alert">x</button>
                                <p >
                                    <small>Termin je popunjen. Potražite ostale termine.
                                    </small>
                                </p>
                            </div>
                        </div>
                        {{Session::forget('kapacitet')}}
                    @endif


                </div>



            @endif

        </div>
    @endfor
    <div class="row justify-content-center pt-4">
        {{$appointments->links()}}
    </div>




@endsection
