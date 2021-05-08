@extends('admin.layouts.ec')
@section('title', 'Setting System')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Data Setting </h5>
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
                        <form id="form_system" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group{{ $errors->has('rate') ? ' has-error' : '' }}">
                                <label>Rate</label>
                                <input type="text" class="form-control {{ $errors->has('rate') ? ' is-invalid' : '' }}" 
                                    id="rate" name="rate" placeholder="" 
                                    value="{{ old('rate') }}"/>
                                @if ($errors->has('rate'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('rate') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="logins-button" style="margin-top:10px">
                                <button type="submit" class="btn btn-primary lnj-color submit">Submit</button>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection