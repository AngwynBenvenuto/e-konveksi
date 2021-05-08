@extends('admin.layouts.ec')
@section('title', $title)
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div id="div_back" class="" style="text-align:right;">
                <a id="" href="{{ route('admin.master.bank') }}" class="btn  btn-primary mb-2">
                    <i class="icon icon-fas fa-chevron-left fas fa-chevron-left"></i> Return to Details
                </a>
            </div>
            <div class="ibox ">
                <div class="ibox-title"></div>
                <div class="ibox-content">
                    <form id="form_bank" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-2">
                                <label>Nama Bank</label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" style="position:relative">
                                    <input type="text" class="form-control" 
                                        placeholder="Nama.." id="bank_nama" autocomplete="off"
                                        name="bank_nama" value="{{ old('bank_nama', $nama) }}"/>
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
                                        placeholder="Deskripsi.." id="bank_deskripsi" autocomplete="off"
                                        name="bank_deskripsi">{{ old('bank_deskripsi', $description, '') }}</textarea>
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