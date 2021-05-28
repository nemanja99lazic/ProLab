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
    <div class="jumbotron">
        <div class="container">
            <h1>ProLab</h1>
            <a href="{{ route(Session::get('user')['userType'].'.logout') }}">Logout</a><br>
            <a href="{{ route('teacher.addsubject.get') }}">Logout</a><br>
        </div>
    </div>
    <div class="container">
        @if(!empty(Session::get('success')))
            {{Session::forget('success')}}
            <div class="row">
                <div class="col">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Your request for creating new subject successfully sent!
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col">
                <form action="{{ route('teacher.addsubject.post') }}" method="post">
                    @csrf
                    <table class="table w-50 m-auto">
                        <tr>
                            <td colspan="2">
                                <h2 class="text-center font-weight-bold">Create new subject</h2>
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle">Subject name:</td>
                            <td>
                                @if($errors->first('name'))
                                    <input type="text" class="form-control m-1 is-invalid w-100" name="name" id="name" autocomplete="off" placeholder="Dodaj za validate" value="{{old("name")}}">
                                    <div class="text-danger text-left h6 small">{{ $errors->first('name') }}</div>
                                @else
                                    <input type="text" class="form-control m-1 w-100" name="name" id="name" autocomplete="off" value="{{old("name")}}">
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle">Select associates:</td>
                            <td>
                                <select name="teachers_select[]" id="teachers_select" multiple size="5" class="w-100 form-control">
                                    @foreach($teachers as $teacher)
{{--                                        <option value="">{{ $teacher->user()->surname.'x'.$teacher->user()->forename }}</option>--}}
                                        <option>{{ $teacher->user->forename.' '.$teacher->user->surname.' ('.$teacher->user->email.')' }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center">
                                <button type="submit" class="btn btn-dark w-50">Create subject</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
