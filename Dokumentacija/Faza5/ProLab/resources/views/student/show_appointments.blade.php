<?php //Autor: Valerijan Matvejev 2018/0257; Prikaz svih termina za dati lab ?>
@extends('layout.main')
@section('content')

    <script src="{{ asset('js/navbar.js') }}" defer></script>
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



    @for ($i = 0; $i < count($appointments);$i+=2 )
        <div class="row">

            @if(($i)<count($appointments))
                <div class="col-6">

                    <table id="dtDynamicVerticalScrollExample" class="table table-bordered m-auto " style="width: 80vh" >
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

                                        <button
                                            type="submit" class="btn btn-secondary p-1 m-1"
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


                                <td class=" text-center" style="width: 20%">{{$redniBrojevi[$i+1]++}} </td>
                                <td class=" text-center" style="width: 40%">{{explode(',',$a)[0]." ".explode(',',$a)[1]}} </td>
                                <td class=" text-center" style="width: 40%">{{explode(',',$a)[2]}} </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                </div>



                @endif
                @if(($i+1)<count($appointments))
                    <div class="col-6">

                        <table id="dtDynamicVerticalScrollExample" class="table table-bordered m-auto " style="width: 80vh" >
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

                                            <button
                                                type="submit" class="btn btn-secondary p-1 m-1"
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

                    </div>



                @endif

        </div>
    @endfor





@endsection
