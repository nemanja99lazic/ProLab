{{--
    Autor: Slobodan Katanic 2018/0133
--}}

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <div class="container">
        @if(!empty(Session::get('success')))
            {{ Session::forget('success') }}
            <div class="row">
                <div class="col">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Vaš zahtev za kreiranje predmeta je uspešno poslat!
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col">
                <form action="{{ route('teacher.addsubject.post') }}" method="post">
                    @csrf
                    <table class="table w-50 m-auto table-borderless">
                        <tr>
                            <td>
                                <h3 class="text-center font-weight-bold">Kreiranje novog predmeta</h3>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="pl-2 font-weight-bold">Naziv predmeta</div>
                                @if($errors->first('name'))
                                    <input type="m-0 text" class="form-control is-invalid w-100" name="name" id="name" autocomplete="off" placeholder="" value="{{old("name")}}">
                                    <div class="text-danger text-left h6 mt-1 small">{{ $errors->first('name') }}</div>
                                @else
                                    <input type="m- 0text" class="form-control w-100" name="name" id="name" autocomplete="off" value="{{old("name")}}">
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="pl-2 font-weight-bold">Šifra predmeta</div>
                                @if($errors->first('code'))
                                    <input type="m-0 text" class="form-control m-1 is-invalid w-100" name="code" id="code" autocomplete="off" placeholder="" value="{{old("code")}}">
                                    <div class="text-danger text-left mt-1 h6 small">{{ $errors->first('code') }}</div>
                                @else
                                    <input type="text" class="m-0 form-control m-1 w-100" name="code" id="code" autocomplete="off" value="{{old("code")}}">
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="pl-2"><b>Izabrani saradnici</b> (pritisnite <i>ctrl</i> dugme prilikom biranja više od jednog saradnika)</div>
                                <select name="teachers_select[]" id="teachers_select" multiple size="3" class="w-100 form-control">
                                    @foreach($teachers as $teacher)
{{--                                        <option value="">{{ $teacher->user()->surname.'x'.$teacher->user()->forename }}</option>--}}
                                        <option>{{ $teacher->user->forename.' '.$teacher->user->surname.' ('.$teacher->user->email.')' }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center">
                                <button type="submit" class="btn btn-dark w-50">Napravi predmet</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
