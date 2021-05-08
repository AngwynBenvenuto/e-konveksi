@extends('front.layouts.ec')
@section('title', 'Reset Password')
@section('content')
    <div class="page-reset">
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
                    <form id="form_change_password" method="post">
                        @csrf
                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="form-label">Email</label>
                            <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" type="email" 
                                name="email" id="email" value="{{ old('email', $email) }}" autocomplete="off">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" 
                            name="password" placeholder="Password" value="{{ old('password') }}" autocomplete="off"/>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <input type="password" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" id="password_confirmation" 
                            name="password_confirmation" placeholder="Confirm Password" 
                            value="{{ old('password_confirmation') }}" autocomplete="off"/>
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                        <input id="buttonLogin" type="submit" 
                            class="btn btn-default bg-primary" value="Update Password">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection