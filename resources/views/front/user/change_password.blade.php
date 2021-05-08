@extends('front.layouts.ec')
@section('title', $title)
@section('content')
    <div class="page-white page-user pb-3">
        <div class="container">
            <nav aria-label="breadcrumb" class="breadcrumbs py-3">
                {!! Breadcrumbs::render('user.change_password') !!}
            </nav>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <?php
                        echo \Lintas\libraries\CBlocks::render('member/account/nav');
                    ?>
                </div>
                <div class="col-sm-9">
                    <div class="card mb-3">
                        <div class="card-header">{{ __('Ubah Password') }}</div>
                        <div class="card-body">
                            <?php echo \Lintas\libraries\CBlocks::render('message'); ?>
                            <form role="form" method="POST" action="{{ route('user.change_password') }}">
                                @csrf
        
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password">{{ __('Password Lama') }}</label>
                                    <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" 
                                        id="password" name="password" placeholder="Password" value="{{ old('password') }}"/>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
        
                                <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                                    <label for="new_password">{{ __('Password Baru') }}</label>
                                    <input type="password" class="form-control {{ $errors->has('new_password') ? ' is-invalid' : '' }}" id="new_password" 
                                        name="new_password" placeholder="New Password" value="{{ old('new_password') }}"/>
                                    @if ($errors->has('new_password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('new_password') }}</strong>
                                        </span>
                                    @endif
                                </div>
        
                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <label for="password_confirmation">{{ __('Konfirmasi Password') }}</label>
                                    <input type="password" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" 
                                        id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" value="{{ old('password_confirmation') }}"/>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="logins-button" style="margin-top:10px">
                                    <button type="submit" class="btn btn-primary lnj-color submit">Reset Password</button>
                                    
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection