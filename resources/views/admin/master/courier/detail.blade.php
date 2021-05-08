@extends('admin.layouts.ec')
@section('title', $title)
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div id="div_back" class="" style="text-align:right;">
                <a id="" href="{{ route('admin.master.courier') }}" class="btn  btn-primary mb-2">
                    <i class="icon icon-fas fa-chevron-left fas fa-chevron-left"></i> Return to Details
                </a>
            </div>
            <div class="ibox ">
                <div class="ibox-title"></div>
                <div class="ibox-content">
                    <form id="form_courier" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-2">
                                <label>Nama courier</label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" style="position:relative">
                                    <input type="text" class="form-control"
                                        placeholder="Nama.." id="courier_nama" autocomplete="off"
                                        name="courier_nama" value="{{ old('courier_nama', $nama) }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>Deskripsi</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group" style="position:relative">
                                    <textarea class="form-control summernote"
                                        placeholder="Deskripsi.." id="courier_deskripsi" autocomplete="off"
                                        name="courier_deskripsi">{{ old('courier_deskripsi', $description, '') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div style="clear:both"></div>
                        <hr>
                        <div class="form-actions clear-both " style="text-align: right;">
                            <button type="submit" href="javascript:;" class="btn btn-primary lnj-color btnSubmit">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {



        });
    </script>
@endsection