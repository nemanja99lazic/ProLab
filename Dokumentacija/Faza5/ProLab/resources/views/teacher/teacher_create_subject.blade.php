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
        <div class="row">
            <div class="col">
                <form action="{{ route('teacher.addsubject.post') }}" method="post">
                    <table class="table">
                        <tr>
                            <th colspan="2">Create new subject</th>
                        </tr>
                        <tr>
                            <td>Subject name:</td>
                            <td><input type="text" name="name" id="name"></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <select name="teachers_select" id="teachers_select">
                                    @foreach($teachers as $teacher)
{{--                                        <option value="">{{ $teacher->user()->surname.'x'.$teacher->user()->forename }}</option>--}}
                                        <option value="">{{ $teacher->user->forename.' '.$teacher->user->forename }}</option>
                                    @endforeach
                                </select>
                                <button class="btn" disabled>Add</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
