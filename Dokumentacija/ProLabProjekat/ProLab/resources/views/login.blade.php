<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <title>Log in</title>
</head>
<body>
<div class="jumbotron">
    <div class="container-fluid">
        <h1>ProLab</h1>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-4 offset-4">
            <form action="{{ route('guest.loginSubmit') }}" method="post">
                @csrf
                <table class="table text-center">
                    <tr>
                        <td>username:</td>
                        <td><input type="text" name="username" id="username" autocomplete="off"></td>
                    </tr>
                    @error('username')
                    <tr>
                        <td colspan="2">
                            {{ $message }}
                        </td>
                    </tr>
                    @enderror
                    <tr>
                        <td>password:</td>
                        <td><input type="password" name="password" id="password" autocomplete="off"></td>
                    </tr>
                    @error('password')
                    <tr>
                        <td colspan="2">
                            {{ $message }}
                        </td>
                    </tr>
                    @enderror
                    <tr class="text-center">
                        <td colspan="2">
                            <input type="submit" value="Log in" class="btn btn-dark">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <a href="{{ route('guest.register') }}">Don't have account?</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
</body>
</html>

