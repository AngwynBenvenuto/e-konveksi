@extends('admin.layouts.ec')
@section('title', '404 Page Not Found')
@section('content')    
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="well">
                            <h1>Sorry, an error has occured</h1>
                            <p>Requested page not found!</p><br>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-home"></i> Take me to home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection