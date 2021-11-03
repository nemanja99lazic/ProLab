<!-- Nemanja Lazic 2018/0004 -->

@extends('layout.profesor.main_stranica_predmeta')
@section('page-title')
    Dodavanje laboratorijske vežbe
@endsection
@section('content')
    
    <link rel="stylesheet" href="{{asset("css/teacher/add_lab_style.css")}}">
    <script src="{{asset("js/teacher/add_lab_script.js")}}"></script>

    <br>
    <h3 class="font-weight-bold text-center border-bottom-12 offset-0"  >Dodavanje laboratorijske vežbe</h3>
    <br>

    <class class="row justify-content-center">
        <class class="col-4">
            <h4 class="text-center" id='header-opste'> Opšte</h4>
            <table class="table table-borderless tabela-opste">
                <tr>
                    <td>Ime laboratorijske vežbe:</td>
                    <td><input type="text" name="ime-laba" id="ime-laba" class="form-control" placeholder="Ime" required></td>
                </tr>
                <tr>
                    <td>Opis:</td>
                    <td><textarea name="opis-laba" id="opis-laba" cols="20" rows="3" class="form-control" placeholder="Opis"></textarea></td>
                </tr>
                <tr>
                    <td>Datum i vreme isteka prijave:</td>
                    <td><input type="datetime-local" class="form-control datume-vreme-polje" name="rok-laba" id="rok-laba"></td>
                </tr>
            </table>
            <div class="text-center">
                <button class="btn btn-outline-secondary" id="btn-nazad" data-code={{$code}}>Nazad</button>
                <button class="btn btn-outline-success" id="btn-definisi-lab" data-code={{$code}}>Kreiraj laboratorijsku vežbu</button>
            </div>
        </class>
        <class class="col-8">
            <h4 class="text-center">Termini</h4>
            <br>
            <table class="table table-striped table-bordered" id="tabela-termini">
                <tr>
                    <th>Sala</th>
                    <th>Kapacitet</th>
                    <th>Lokacija</th>
                    <th>Datum i vreme održavanja</th>
                    <th>Dodaj</th>
                </tr>
                <tr id="forma-dodaj-lab">
                    <td><input type="text" name="sala" id="sala" class="form-control" placeholder="Sala" required></td>
                    <td><input type="number" name="kapacitet" id="kapacitet" min="1" class="form-control" placeholder="Kapacitet" required></td>
                    <td><input type="text" name="lokacija" id="lokacija" class="form-control" placeholder="Lokacija"required></td>
                    <td><input type="datetime-local" name="datum-vreme" id="datum-vreme" class="form-control datum-vreme-polje" required></td>
                    <td><button id="btn-dodaj-termin">+</button></td>
                </tr>
            </table>
        </class>
    </class>
    <!--<br>
    <class class="row justify-content-center">
        <class class="col-auto">
            <h4>Termini</h4>
        </class>
    </class>
    <class class="row justify-content-center">
        <class class="col-auto">
            <table class="table table-striped table-bordered" id="tabela-termini">
                <tr>
                    <th>Sala</th>
                    <th>Kapacitet</th>
                    <th>Lokacija</th>
                    <th>Datum i vreme održavanja</th>
                    <th>Dodaj</th>
                </tr>
                <tr id="forma-dodaj-lab">
                    <td><input type="text" name="sala" id="sala" class="form-control" placeholder="Sala" required></td>
                    <td><input type="number" name="kapacitet" id="kapacitet" min="1" class="form-control" placeholder="Kapacitet" required></td>
                    <td><input type="text" name="lokacija" id="lokacija" class="form-control" placeholder="Lokacija"required></td>
                    <td><input type="datetime-local" name="datum-vreme" id="datum-vreme" class="form-control datum-vreme-polje" required></td>
                    <td><button id="btn-dodaj-termin">+</button></td>
                </tr>
            </table>
        </class>
    </class> -->
    <!--<br>
    <class class="row justify-content-center">
        <div class="col-auto">
            <button class="btn btn-outline-secondary" id="btn-nazad" data-code={{$code}}>Nazad na pregled laboratorijskih vežbi</button>
        </div>
        <div class="col-auto">
            <button class="btn btn-outline-success" id="btn-definisi-lab" data-code={{$code}}>Kreiraj laboratorijsku vežbu</button>
        </div>
    </class>
    -->

    <!-- Alert - dinamicki menjan po potrebi u javascriptu-->
<div class="row justify-content-center">
    <div class="col-8">
        <div class="alert alert-dismissible" id="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <p id="alert-tekst"></p>
        </div>
    </div>
</div>
@endsection