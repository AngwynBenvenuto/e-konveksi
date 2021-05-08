@extends('admin.layouts.ec')
@section('title', 'Change Password')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Change Password </h5>
                </div>
                <div class="ibox-content">
                    <div class="col-md-12">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <form id="form_change_password" method="post" enctype="multipart/form-data">
                            @csrf
    
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label>Password</label>
                                <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" 
                                    id="password" name="password" placeholder="" 
                                    value="{{ old('password') }}"/>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
    
                            <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                                <label>Password Baru</label>
                                <input type="password" class="form-control {{ $errors->has('new_password') ? ' is-invalid' : '' }}" 
                                    id="new_password" name="new_password" 
                                    placeholder="" value="{{ old('new_password') }}"/>
                                @if ($errors->has('new_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('new_password') }}</strong>
                                    </span>
                                @endif
                            </div>
    
                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label>Konfirmasi Password</label>
                                <input type="password" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" 
                                    id="password_confirmation" name="password_confirmation" 
                                    placeholder="" value="{{ old('password_confirmation') }}"/>
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
@endsection