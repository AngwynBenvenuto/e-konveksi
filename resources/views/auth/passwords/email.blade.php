@extends('front.layouts.ec')
@section('title', 'Reset Password')
@section('content')
    <div class="page-password">
        <div class="container">
            <nav aria-label="breadcrumb" class="breadcrumbs py-3">
                {!! Breadcrumbs::render('reset') !!}
            </nav>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center d-flex aligns-items-center">
                    <img class="img-responsive" src="{{ asset('public/img/reset.png') }}" style="width:150px">
                </div>
                <div class="col-md-6">
                    <h5 class="">Reset Password</h5>
                    <form id="form_reset" method="post">
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
                        <input id="buttonLogin" type="submit" class="btn btn-default bg-primary" value="Reset">
                        <div class="hr">
                            <div></div>
                            <div>Atau</div>
                            <div></div>
                        </div>
                        <div class="text-center ">
                            Sudah punya akun?&nbsp;
                            <strong>
                                <a class="text-primary" href="{{ route('login') }}">
                                    Login
                                </a>
                            </strong>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection