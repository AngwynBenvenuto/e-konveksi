@extends('front.layouts.ec')
@section('title', 'Login')
@section('content')
    <div class="page-login">
        <div class="container">
            <nav aria-label="breadcrumb" class="breadcrumbs py-3">
                {!! Breadcrumbs::render('login') !!}
            </nav>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center d-flex aligns-items-center">
                    <img class="img-responsive" src="{{ asset('public/img/login.jpg') }}" style="width:250px">
                </div>
                <div class="col-md-6">
                    <h5>Login</h5>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-error">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('verification_error'))
                        <div class="alert alert-warning">
                            {{ session('verification_error') }}
                            <br>
                            <a href="{{ url('/auth/verify?email='.session('email')) }}">Verifikasi ulang</a>
                        </div>
                    @endif
                    <form action="{{ route('login') }}" id="formAuth" method="post" role="form">
                        @csrf
                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="form-label">Email</label>
                            <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" type="email"
                                name="email" id="email" value="{{ old('email') }}" autocomplete="off">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="form-label">Password</label>
                            <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" type="password"
                                id="password" name="password" value="{{ old('password') }}" autocomplete="off">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col text-left float-left">
                                <input id="buttonLogin" type="submit" class="btn btn-default bg-primary" value="Login">
                            </div>
                            <div class="col s3 text-right float-right">
                                <strong>
                                    <a href="{{ route('auth.password.reset') }}" class="text-primary">
                                        Lupa password?
                                    </a>
                                </strong>
                            </div>
                        </div>

                        <div class="hr">
                            <div></div>
                            <div>Atau</div>
                            <div></div>
                        </div>

                        <div class="text-center">
                            <p>
                                Belum punya akun?<br>
                                <strong>
                                    <a href="{{ route('register') }}" class="text-primary">
                                        Daftar disini !!
                                    </a>
                                </strong>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection