<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

</body>
</html>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">



<div class="row justify-content-center">
    <form action="{{route('valerijan')}}" method="POST">
        @csrf
        <input type="file" value="" name="pretraga" id="pretraga">
        <button type="submit" class="btn-info" name="pretrazi" id="prtrz"> Pretrazi </button>

    </form>





</div>
@foreach($rezultat as $r)
    <div class="jumbotron">
        {{$r->idLabExercise}}
    </div>
@endforeach



