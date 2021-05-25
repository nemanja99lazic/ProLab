<!--
    Nemanja Lazic 2018/0004
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>All subjects</title>
</head>
<body>
    <div class="jumbotron">
        <div class="container">
            <h1>ProLab</h1>
            <a href="{{ route(Session::get('user')['userType'].'.logout') }}">Logout</a>
        </div>
    </div>
    <div class="container">
        <div clas="row">
            <div class="col">
                <h2 class="mb-5 mt-5">List of subjects which you can enroll in</h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-bordered table-striped text-center" id="subject_enrollment_table">
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th></th>
                    </tr>
                    @if(count($subjects) > 0)
                        @foreach ($subjects as $subject)
                            <tr>
                                <td>{{$subject->code}}</td>
                                <td>{{$subject->name}}</td>
                                <td>
                                    <form action="{{ route('student.sendJoinRequest') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="idSubject" id="idSubject" value="{{$subject->idSubject}}">
                                        <button type="submit" class="btn btn-primary">Send request</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </div>
        </div>
        <div class="row">
            {{$subjects->links()}}
        </div>
    </div>
</body>
</html>