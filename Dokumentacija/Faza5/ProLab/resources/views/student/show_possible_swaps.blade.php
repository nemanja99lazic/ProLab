<?php //Autor: Valerijan Matvejev 2018/0257; Prikaz svih termina za dati lab ?>
@extends('layout.main')
@section('content')

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
                                <div class="form-check  ">

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
