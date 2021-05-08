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
                    <form id="form_insert_qr" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="control-group ">
                            <label id="" class="form-label control-label">Project</label>
                            <div class="controls">
                                <span class="" name="project_name" id="project_name">{{ $project_name }}</span>
                            </div>
                            <input type="hidden" name="project_id" id="project_id" value="{{ $project_id }}"/>
                        </div>
                        <div class="control-group ">
                            <label id="" class="form-label control-label">Penjahit</label>
                            <div class="controls">
                                <span class="" name="penjahit_name" id="penjahit_name">{{ $penjahit_name }}</span>
                            </div>
                            <input type="hidden" name="penjahit_id" id="penjahit_id" value="{{ $penjahit_id }}"/>
                        </div>
                        <div class="control-group ">
                            <label id="" class="form-label control-label">Brand</label>
                            <div class="controls">
                                <input type="text" class="form-control"
                                 id="brand" name="brand" value="{{ old('brand') }}"/>
                            </div>
                        </div>
                        <div class="control-group ">
                            <label id="" class="form-label control-label">Jenis Kain</label>
                            <div class="controls">
                                <input type="text" class="form-control"
                                 id="jenis_kain" name="jenis_kain" value="{{ old('jenis_kain') }}"/>
                            </div>
                        </div>
                        <div class="control-group ">
                            <label id="" class="form-label control-label">Cara Perawatan</label>
                            <div class="controls">
                                <textarea class="form-control summernote "
                                    placeholder="perawatan.." id="perawatan" tabindex="9"
                                    name="perawatan">{{ old('perawatan') }}</textarea>
                            </div>
                        </div>
                        <div style="clear:both"></div>
                        <hr>
                        <div class="form-actions clear-both " style="text-align: right;">
                           <button type="submit" class="btn btn-primary lnj-color btnSubmit">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection