<?php //Autor: Valerijan Matvejev 2018/0257 ;  Ispis svih odabranih predmeta?>
@extends('layout.main')
@section('content')



    <br>
    <h3 class="font-weight-bold text-center border-bottom-12"  >Spisak predmeta koje ste izabrali</h3>
    <br>

    <div class="row justify-content-center">
        <div class="col-auto">
            <table class="table table-bordered"style="width: 80vh" >
                <thead class="thead-light">
                <tr>

                    <th  class="font-weight-bold text-center" style="width: 50%" scope="col" >Predmet</th>
                    <th class="font-weight-bold text-center" style="width: 50%"scope="col">Stranica</th>

                </tr>
                </thead>
                <tbody>

                @foreach($subjects as $subject)


                    <tr style="width: 50%">

                        <td class=" text-center">{{$subject->name}}</td>
                        <td class=" text-center"><a href="{{ route('student.subject.index',$subject->code) }}">Link-></a> </td>

                    </tr>
                @endforeach

                </tbody>
            </table>

        </div>
    </div>





@endsection
