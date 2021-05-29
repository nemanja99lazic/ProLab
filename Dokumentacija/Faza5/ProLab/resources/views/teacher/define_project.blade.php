<!-- Nemanja Lazic 2018/0004 -->

@extends('layout.nemanja_main_layout')
@section('contentInsideTheContainer')

<link rel="stylesheet" href="{{asset('css/teacher/define_project_style.css')}}">
<script src="{{asset('js/teacher/define_project_script.js')}}"></script>

<div class="row">
    <div class="col text-center">
        <h1>Definisanje projekta</h1>
    </div>
</div>
<br>
<div class="row">
    <div class="col text-center">
        <table class="table" id="tabela-definisi-projekat">
            <tr>
                <td>
                    <label>Naziv projekta</label>
                </td>
                <td>
                    <input type="text" name="nazivProjekta" id="nazivProjekta" placeholder="Naziv projekta" class="form-control" required>
                </td>
            </tr>
            <tr>
                <td><label for="">Minimalan broj članova</label></td>
                <td><input type="number" name="minBrClanova" id="minBrojClanova" placeholder="1" min="1" class="form-control" required></td>
            </tr>
            <tr>
                <td><label for="">Maksimalan broj članova</label></td>
                <td><input type="number" name="maxBrClanova" id="maxBrojClanova" placeholder="1" min="1" class="form-control" required></td>
            </tr>
            <tr>
                <td><label for="">Rok</label></td>
                <td><input type="date" name="rok" id="rok" class="form-control" required></td>
            </tr>
            <tr>
                <td>
                    <button class="btn btn-outline-secondary" id="btn-nazad" data-code={{$code}}>Nazad na pregled projekta</button>
                </td>
                <td>
                    <button class="btn btn-outline-success btn" id="btn-potvrdi-definisanje">Definiši projekat</button>
                </td>
            </tr>
        </table>
    </div>
</div>

<!-- Alert - dinamicki menjan po potrebi u javascriptu-->
<div class="row">
    <div class="col">
        <div class="alert alert-dismissible" id="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <p id="alert-tekst"></p>
        </div>
    </div>
</div>

<!-- Dodavanje bootstrap modala (DIJALOGA) -->
<div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Definisanje projekta</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <div class="modal-body" class="font-weight-bold">
            <p class="font-weight-bold">Uneseni podaci</p>
            <br>
            <div id="modal-div-naziv-projekta" class="font-weight-bold">
                Naziv projekta: &nbsp;
                <p id="modal-naziv-projekta" class="font-weight-normal"></p>
            </div>
            <div id="modal-div-min-broj-clanova" class="font-weight-bold">
                Minimalan broj članova: &nbsp;
                <p id="modal-min-broj-clanova" class="font-weight-normal"></p>
            </div>
            <div id="modal-div-max-broj-clanova" class="font-weight-bold">
                Maksimalan broj članova: &nbsp;
                <p id="modal-max-broj-clanova" class="font-weight-normal"></p>
            </div>
            <div id="modal-div-rok" class="font-weight-bold">
                Rok: &nbsp;
                <p id="modal-rok" class="font-weight-normal"></p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary" id="modal-btn-potvrdi">Potvrdi</button>
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" id ="modal-btn-izmeni">Izmeni</button>
          </div>
      </div>
    </div>
  </div>


@endsection