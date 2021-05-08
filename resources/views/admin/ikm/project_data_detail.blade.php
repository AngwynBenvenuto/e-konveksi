@extends('admin.layouts.ec')
@section('title', $title)
@section('content')
    <div class="row">
        <div class="col-12">
            <div id="div_back" class="" style="text-align:right;">
                <a id="" href="{{ route('admin.dashboard') }}" class="btn  btn-primary mb-2">
                    <i class="icon icon-fas fa-chevron-left fas fa-chevron-left"></i> Kembali ke dashboard
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <form id="form_project_data_detail" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Project</label>
                                    <div class="controls">
                                        <span class="" name="project_name" id="project_name">{{ $project_name }}</span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Penjahit</label>
                                    <div class="controls">
                                        <span class="" name="penjahit_name" id="penjahit_name">{{ $penjahit_name }}</span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Brand</label>
                                    <div class="controls">
                                        <span class="" name="brand" id="brand">{{ $brand }}</span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Jenis Kain</label>
                                    <div class="controls">
                                        <span class="" name="jenis_kain" id="jenis_kain">{{ $jenis_kain }}</span>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Cara Perawatan</label>
                                    <div class="controls">
                                        <span class="" name="cara_perawatan" id="cara_perawatan">{!! $cara_perawatan !!}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Kode QR</label>
                                    <div class="controls">
                                        <div id="img_qr"
                                            style="background-repeat:no-repeat;background-size:100%;background-position:center;border:1px solid gray;margin:0px auto 10px auto;width:200px;height:200px;">
                                            <img src="{{ $project_qr }}" style="width:100%;height:100%;" onerror="this.src='{{ asset('public/img/no_image.png') }}'">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection