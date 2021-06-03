
<input hidden value="{{ request()->code }}" id="sifraPredmeta">
<input hidden value="{{ request()->idLab }}" id="sifraLaba">

            <div class="col-5 tabs d-flex flex-column justify-content-end p-0 ">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link btn-outline-dark {{ request()->is('student/subject/*/index')  ? 'active' : ''}}" id="nav-subject-tab" data-toggle="tab" href="" role="tab" aria-controls="nav-home" aria-selected="true" style="font-size: medium">Stranica predmeta</a>
                        <a class="nav-item nav-link btn-outline-dark {{ request()->is('student/subject/*/lab') || request()->is('student/subject/*/lab/*') ? 'active' : ''}}" id="nav-lab-tab" data-toggle="tab" href="" role="tab" aria-controls="nav-profile" aria-selected="false"style="font-size: medium" >Laboratorijske vežbe</a>
                        <a class="nav-item nav-link btn-outline-dark {{ request()->is('student/subject/*/project')  ? 'active' : ''}}" id="nav-project-tab" data-toggle="tab" href="" role="tab" aria-controls="nav-contact" aria-selected="false"style="font-size: medium" >Projekat</a>
                    </div>
                </nav>
            </div>
            <div class="col-4 d-flex flex-column justify-content-center align-items-start">
                <img src="/images/ProLabLOGO.png" class="rounded" width="48%">
            </div>
            <div class="col-3 d-flex flex-row justify-content-end">
                <ul class="nav">
                    <li class="nav-item p-2">
                        <a class="nav-link btn btn-dark rounded-pill" href="{{ route(Session::get('user')['userType'].'.index') }}">Pocetna</a>
                    </li>
                    <li class="nav-item p-2">
                        <a class="nav-link btn btn-dark rounded-pill" href="{{ route(Session::get('user')['userType'].'.logout') }}">Odjavi se</a>
                    </li>
                </ul>
            </div>


