@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>



                <div class="card-body">
                    <form method="POST" action="/asd">

                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                <input name="username" id="username" type="text" class="form-control  @error('username') is-invalid @enderror">
                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input  id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" >
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <input type="submit" value="login" class ="btn btn-primary" >

                        </div>



                    </form>
                </div>
            </div>
        </div>
    </div>




</div>
@endsection
