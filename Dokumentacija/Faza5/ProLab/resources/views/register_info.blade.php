<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Register info</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Vas zahtev za registraciju je uspesno poslat!</h1>
                <a href="{{ route('guest.login.get') }}">Back</a>
            </div>
        </div>
    </div>
</body>
</html>
