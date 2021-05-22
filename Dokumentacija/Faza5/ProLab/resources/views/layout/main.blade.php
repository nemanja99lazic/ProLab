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
    <style>
        hr{
            height: 20px;
            background-color: #000066;
            border: none;
            padding: 0;
        }
        .hero{
            background-color:#ffffdd ;
        }


    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <header>

            </header>
        </div>

        <div class="row">
            <div class="col hero">

                    @yield('content')

            </div>

        </div>



        <div class="row">
            <div class="col fixed-bottom">
                <hr style="width: 100%; color: #000066 " >






                <footer class="page-footer bg-light " >

                <div class="text-lg-center text-md-center text-sm-center"  >
                    <p class="justify-content-center">© ProLab/Valerijan Matvejev 2018/0257, Slobodan Katanić 2018/0133, Nemanja Lazić 2018/0004, Sreten Živković 2018/0008
                    </p>
                    <p>
                        Elektrotehnički fakultet, Univerzitet u Beogradu
                    </p>

                </div>

            </footer>
            </div>
        </div>


    </div>



</body>
</html>
