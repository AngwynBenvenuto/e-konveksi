@extends('admin.layouts.ccore.login')
@section('content')
    <div class="">
        <form action="{{ route('admin.login') }}" method="post" id="form-login" style="margin-top:10px" role="form">
            @csrf
            <div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
                <label>{{ __('Name') }}</label>
                <input type="text" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" id="email" 
                    placeholder="" name="username" value="{{ old('username') }}"
                    autocomplete="off"/>
                @if ($errors->has('username'))
                    <span class="help-block">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                <label>{{ __('Password') }}</label>
                <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" 
                    id="password" placeholder="" name="password" 
                    value="{{ old('password') }}" autocomplete="off"/>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="login-buttons" style="margin-top:10px">
                <button id="btnSignIn" type="submit" class="btn btn-primary btn-block btn-large lnj-color">{{ __('Sign In') }}</button>
            </div>
            <div style="float:right;margin-bottom:1em;" class="py-3">
                <a class="btn-forgot-password" href="javascript:void(0);">{{ __('Forgot Password?') }}</a>
            </div>
        </form>
    </div>
@endsection