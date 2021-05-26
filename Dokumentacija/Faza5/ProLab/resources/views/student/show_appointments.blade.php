@extends('layout.main')
@section('content')

    <script src="{{ asset('js/navbar.js') }}" defer></script>
    @foreach($appointments as $appointment)

        <br>
        <h3 class="font-weight-bold text-center border-bottom-12 offset-0"  >asd</h3>
        <br>


        <div class="row justify-content-center">
            <div class="col-auto">

                <table id="dtDynamicVerticalScrollExample" class="table table-bordered " style="width: 80vh" >
                    <thead class="thead-light">
                    <tr>

                        <th  class="font-weight-bold text-center" style="width: 50%" scope="col" >heder 1</th>
                        <th class="font-weight-bold text-center" style="width: 50%"scope="col">heder 2</th>

                    </tr>
                    </thead>
                    <tbody>


                    <tr style="">


                        <td class=" text-center">a </td>
                        <td class=" text-center"> b</td>
                    </tr>


                    <tr style="">


                        <td class=" text-center">A </td>
                        <td class=" text-center">B</td>
                    </tr>






                    </tbody>
                </table>


            </div>
        </div>
    @endforeach




@endsection
