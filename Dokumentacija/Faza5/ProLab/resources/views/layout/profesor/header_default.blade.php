<div class="row header-with-background pt-3">
    <div class="col-12 d-flex  justify-content-end pb-2 pt-0 ">
        <ul class="nav d-flex align-items-center">
            <li class="nav-item ml-1 mr-1">
                {{$userName}}
            </li>
            <li class="nav-item ml-1 mr-1">
                <a class="nav-link btn btn-dark rounded-pill" href="{{ route(Session::get('user')['userType'].'.index') }}">Početna</a>
            </li>
            <li class="nav-item ml-1 mr-1">
                <a class="nav-link btn btn-dark rounded-pill" href="{{ route(Session::get('user')['userType'].'.logout') }}">Odjavi se</a>
            </li>
        </ul>
    </div>
    <div class="col-12 tabs d-flex align-bottom  nav nav-tabs justify-content-start pt-4" id="nav-div">
        <nav class="">
            <div class="d-flex align-self-end" class="nav">
                @yield("page-nav")
            </div>
        </nav>
    </div>
</div>
