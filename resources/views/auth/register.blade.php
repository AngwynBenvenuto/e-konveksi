@extends('front.layouts.ec')
@section('title', 'Register')
@section('content')
    <div class="page-register">
        <div class="container">
            <nav aria-label="breadcrumb" class="breadcrumbs py-3">
                {!! Breadcrumbs::render('register') !!}
            </nav>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center d-flex aligns-items-center">
                    <img class="img-responsive" src="{{ asset('public/img/register.jpg') }}" style="width:250px">
                </div>
                <div class="col-md-6">
                    <div class="box">
                        <h5>Register</h5>
                        <form action="{{ route('register') }}" method="post">
                            @csrf

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="form-label" for="name">Nama Lengkap</label>
                                <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" 
                                    name="name" type="text" value="{{ old('name') }}" autocomplete="off">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                <label class="form-label" for="username">Username</label>
                                <input class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" id="username" 
                                    name="username" type="text" value="{{ old('username') }}" autocomplete="off">
                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                                <label class="form-label">Jenis Kelamin</label>
                                <div class="form-controls-stacked" style="position:relative;margin-top:10px;">
                                    <label class="label-block">
                                        <input name="gender" type="radio" id="pria" value="1" checked>&nbsp;Pria
                                        &nbsp;&nbsp;&nbsp;
                                        <input name="gender" type="radio" id="wanita" value="0">&nbsp;Wanita
                                    </label>
                                </div>
                                @if ($errors->has('gender'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('birthdate') ? ' has-error' : '' }}">
                                <label class="form-label" for="birthdate">Tanggal lahir</label>
                                <input type="text" class="form-control date {{ $errors->has('birthdate') ? ' is-invalid' : '' }}" 
                                    value="{{ old('birthdate') }}" 
                                    name="birthdate" id="birthdate" autocomplete="off">
                                @if ($errors->has('birthdate'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('birthdate') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label class="form-label" for="phone">Nomor Telepon</label>
                                <input class="form-control phone {{ $errors->has('phone') ? ' is-invalid' : '' }}" type="text" 
                                    id="phone" name="phone" value="{{ old('phone') }}" autocomplete="off">
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                <label class="form-label" for="address">Alamat</label>
                                <textarea class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" id="address" name="address" type="text" 
                                        value="{{ old('address') }}" autocomplete="off"
                                        placeholder="Jalan segar no 7, Kecamatan ale-ale, Kelurahan nutrijel"></textarea>
                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" 
                                    placeholder="ex: example@email.com" type="email" 
                                    id="email" name="email" value="{{ old('email') }}" autocomplete="off">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
        
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="form-label" for="password">Password</label>
                                <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" 
                                id="password" name="password" value="{{ old('password') }}" autocomplete="off">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
        
                            <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                            <input class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" 
                                type="password" id="password_confirmation" name="password_confirmation" 
                                value="{{ old('password_confirmation') }}" autocomplete="off">
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('agreement') ? ' has-error' : '' }}">
                                <label for="agreement">
                                    <input id="agreement" name="agreement" type="checkbox">
                                    <span class="">Saya setuju dengan  
                                        <a href="{{ route('page.terms') }}" target="_blank" class="text-primary">Syarat dan Ketentuan </a>&amp; 
                                        <a href="{{ route('page.privacy') }}" target="_blank"  class="text-primary">Kebijakan Privasi</a> dari
                                        <strong>{{ env('APP_NAME') }}</strong>
                                    </span>
                                </label><br>
                                @if ($errors->has('agreement'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('agreement') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-default bg-primary" id="buttonSubmit">Register</button>
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
    </div>
@endsection