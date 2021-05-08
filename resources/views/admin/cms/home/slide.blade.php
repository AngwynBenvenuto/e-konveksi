@extends('admin.layouts.ec')
@section('title', 'CMS Slide')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title"></div>
                <div class="ibox-content">
                    <form id="form_slide" method="post" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col">
                                <div id="cms_slide_description" class="multi-image-ajax-description">Click or Drop Files On Box Below</div>
                                <div class="dropzone" id="myDropzone">
                                    <div class="dz-message needsclick">
                                    </div>
                                </div>
                                <div id="div-img"></div>
                            </div>
                        </div>
                        <div style="clear:both"></div>
                        <hr>
                        <div class="form-actions clear-both " style="text-align: right;">
                            <button type="submit" href="javascript:;" 
                                class="btn btn-primary lnj-color" id="btnSubmit">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        Dropzone.autoDiscover = false;
        var uploadedImageMap = {};
        $("#myDropzone").dropzone({
            url: "{{ route('admin.cms.home.slide.upload') }}",
            parallelUploads: 100,
            maxFilesize: 2, // MB
            acceptedFiles: 'image/*',
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, 
            success: function (file, response) {
                var error = response.errCode;
                var msg = response.errMsg;
                if(error == 0) {
                    var data = response.data;
                    var image = data.image_name;
                    $("#div-img").append('<input type="hidden" name="image[]" value="' + image + '">');
                    uploadedImageMap[file.image_name] = file.name;
                }
            },
            removedfile: function (file) {
                var name = '';
                if (typeof file.name !== 'undefined') {
                    name = file.name;
                } else {
                    name = uploadedImageMap[file.image_name];
                }

                file.previewElement.remove();
                $('#div-img').find('input[name="image[]"][value="' + name + '"]').remove();

                $.ajax({
                    url: "{{ route('admin.cms.home.slide.delete') }}",
                    data: { file: name },
                    method: "POST",
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        var msg = response.errMsg;
                        var error = response.errCode;
                        if(error > 0) {
                            $.konveksi.showModal(msg);
                        } 
                    }
                });
            },
            init: function () {
                thisDropzone = this;

                $.ajax({
                    url: "{{ route('admin.cms.home.slide.init') }}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        var error = response.errCode;
                        var msg = response.errMsg;
                        if(error == 0) {
                            var data = response.data;
                            $.each(data, function(key, value) {
                                var mockFile = { name: value.name, size: value.size };
                                thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                                thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.url);
                                thisDropzone.createThumbnailFromUrl(mockFile, value.url);
                            });
                        } else {
                            $.konveksi.showModal(msg);
                        }
                    }
                });
            }
        });
    </script>
@endsection