@extends('admin.layouts.ec')
@section('title', $title)
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div id="div_back" class="" style="text-align:right;">
                <a id="" href="{{ route('admin.setting.role') }}" class="btn  btn-primary mb-2">
                    <i class="icon icon-fas fa-chevron-left fas fa-chevron-left"></i> Return to Details
                </a>
            </div>
            <div class="ibox ">
                <div class="ibox-title"></div>
                <div class="ibox-content">
                    <form id="form_role" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-2">
                                <label>Nama</label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" style="position:relative">
                                    <input type="text" class="form-control " 
                                        placeholder="Name.." id="name" 
                                        name="name" value="{{ old('name', $name) }}" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>Information</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group" style="position:relative">
                                    <textarea class="form-control summernote" 
                                        placeholder="Deskripsi.." id="description" 
                                        name="description">{{ old('description', $description) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div style="clear:both"></div>
                        <hr>
                        <div class="form-actions clear-both " style="text-align: right;">
                            <button type="submit" href="javascript:;" 
                            class="btn btn-primary lnj-color btnSubmit">
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
            $(".btnBack").click(function() {
                window.history.go(-1);
            });


        });

    </script>

@endsection