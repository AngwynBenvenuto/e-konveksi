@extends('admin.layouts.ec')
@section('title', $title)
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title"></div>
                <div class="ibox-content">
                    <form id="form_page_privacy" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col">
                                <div class="form-group" style="position:relative">
                                    <textarea class="form-control summernote " 
                                        placeholder="Content.." id="content" tabindex="8" autocomplete="off"
                                        name="content">{{ old('content', $content) }}</textarea>
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
@endsection