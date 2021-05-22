@extends('layout.main')
@section('content')




    <h3 class="font-weight-bold text-center border-bottom-12"  ">Spisak predmeta koje ste izabrali</h3>


    <table class="table table-bordered" >
        <thead class="thead-light">
        <tr>

            <th  class="font-weight-bold text-center" style="width: 50%" scope="col" >Predmet</th>
            <th class="font-weight-bold text-center" style="width: 50%"scope="col">Stranica</th>

        </tr>
        </thead>
        <tbody>

        @foreach($predmeti as $predmet)
            <tr style="width: 50%">

                <td class=" text-center">{{$predmet->name}}</td>
                <td class=" text-center"><a href="#">www.neznam.rs</a> </td>

            </tr>
        @endforeach

        </tbody>
    </table>





@endsection
