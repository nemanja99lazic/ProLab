<html>
    <head>
        <link rel="stylesheet" href="{{asset('css/app.css')}}" />
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>Predmet</th>
                            <th>Stranica</th>
                        </tr>

                        @foreach ($subjectList as $subject)
                        <tr>
                            <td>{{$subject->name}}</td>
                            <td><a href="{{route()}}">{{$subject->code}}</a></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
