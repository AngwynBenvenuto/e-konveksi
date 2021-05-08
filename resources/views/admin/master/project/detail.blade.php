<?php
    use Lintas\helpers\utils;
?>
@extends('admin.layouts.ec')
@section('title', $title)
@section('content')
    <div class="row">
        <div class="col-lg-12">
            @if($ikm == null)
                <div id="div_back" class="" style="text-align:right;">
                    <a id="" href="{{ route('admin.master.project') }}" class="btn  btn-primary mb-2">
                        <i class="icon icon-fas fa-chevron-left fas fa-chevron-left"></i> Return to Details
                    </a>
                </div>
            @endif
            <div class="ibox ">
                <div class="ibox-title"></div>
                <div class="ibox-content">
                    <form id="form_project" method="post" enctype="multipart/form-data">
                        @csrf
                        @if($id !== null)
                            <div class="row">
                                <div class="col-md-2">Kode</div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" tabindex="1"
                                            placeholder="Kode.." id="project_code"
                                            name="project_code" value="{{ old('project_code', $kode) }}" readonly/>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            @if($session_ikm_id == null || $session_ikm_id == '')
                                <div class="col-md-2">IKM</div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select class="form-control select2" id="ikm_id" name="ikm_id">
                                            <option value="" disabled selected>-- All --</option>
                                            <?php
                                            foreach ($ikm as $k => $v) :
                                                $selected = '';
                                                if (array_get($v, 'id') == $ikm_id) {
                                                    $selected = ' selected="selected"';
                                                }
                                        ?>
                                            <option value="<?php echo array_get($v, 'id'); ?>"<?php echo $selected; ?>><?php echo array_get($v, 'name'); ?></option>
                                        <?php
                                            endforeach;
                                        ?>
                                        </select>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-2">IKM</div>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <div class="form-group-static" style="padding:4px 0">{{ $session_name }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-2">Nama</div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" tabindex="2" id="project_name" autocomplete="off"
                                        name="project_name" value="{{ old('project_name', $nama) }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">Budget</div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control number-format" tabindex="3"
                                        placeholder="" id="project_price" autocomplete="off"
                                        name="project_price" value="{{ (old('project_price', $harga)) }}"/>
                                    <input type="hidden" id="project_price_hidden" name="project_price_hidden" value=""/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">Tanggal Deadline</div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control date"
                                        id="project_published_date" tabindex="5"
                                        name="project_published_date" autocomplete="off"
                                        value="{{ old('project_published_date', $tanggal) }}"/>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-2">Jangka Waktu Project</div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" class="form-control number" tabindex="6"
                                        id="project_deadline" autocomplete="off"
                                        name="project_deadline"  style="position:relative"
                                        maxlength="2"
                                        value="{{ old('project_deadline', $rentang) }}"/>
                                </div>
                                <div style="position:absolute;right:15px;top:10px">Bulan</div>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-md-2">Qty</div>
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <?php
                                        $i = 0;
                                        $ukuran_id = array();
                                        $qty = array();
                                        if($ukuran != null):
                                            foreach ($ukuran as $row_ukuran):
                                    ?>
                                            <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                <?php
                                                    foreach($project_ukuran as $row_selected_ukuran):
                                                        $ukuran_id[] = $row_selected_ukuran['ukuran_id'];
                                                        $qty[] = $row_selected_ukuran['qty'];
                                                    endforeach;
                                                    //var_dump($row_ukuran['id']." ".$ukuran_id[0]." ".in_array($row_ukuran['id'], $ukuran_id));
                                                ?>
                                                <div class="row" style="margin:10px 0">
                                                    <div class="col-xs-3">
                                                        {!! Form::checkbox("projectUkuran[]", $row_ukuran['id'], in_array($row_ukuran['id'], $ukuran_id), array('id'=> 'ukuran-'.$row_ukuran['id'], 'class' => 'ukuran', 'style' => 'position:relative;top:3px')) !!}
                                                        {!! Form::label($row_ukuran['name'], $row_ukuran['name'], array('style' => 'position:relative;margin-bottom:unset;top:-5px;margin:0 10px;width:20px')) !!}
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <input type="text" ukuran-id="{{ $row_ukuran['id'] }}"
                                                            name="projectUkuranValue[]"
                                                            value="{{ in_array($row_ukuran['id'], $ukuran_id) ? $qty[$i] : '1' }}" disabled
                                                            class="ukuran_value cart-list-item-qty qty-touchspin py-0 m-0 text-center border form-control">
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                            $i++;
                                            endforeach;
                                        endif;
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">Video</div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" placeholder="Video URL.." autocomplete="off"
                                        class="form-control"  id="project_video" tabindex="7"
                                        name="project_video" value="{{ old('project_video', $video) }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">Panduan Ukuran</div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?php
                                        $array_panduan = array(
                                            array(
                                                'type' => 'anak',
                                                'label' => 'anak'
                                            ),
                                            array(
                                                'type' => 'dewasa',
                                                'label' => 'dewasa'
                                            )
                                        )
                                    ?>
                                    <label class="label-block">
                                        <?php
                                            // $size_anak = $size_guide_anak;
                                            // $size_dewasa = $size_guide_dewasa;
                                            // $selected = '';
                                            if(count($array_panduan) > 0) {
                                                // if($size_anak != null)
                                                // {
                                                //     echo 'a';
                                                //     $selected='selected="selected"';
                                                // }
                                                // else if ($size_dewasa !=null)
                                                // {
                                                //     echo 'd';
                                                //     $selected='selected="selected"';
                                                // }
                                                // dd($selected);
                                                foreach($array_panduan as $row) :
                                                    echo "<input name='panduan' type='checkbox' id='checkbox_{$row['label']}' class='panduan' value='{$row['label']}'>&nbsp;".ucwords($row['type'])."&nbsp;&nbsp;&nbsp;";
                                                endforeach;
                                            }
                                        ?>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <input type="file" autocomplete="off" accept="image/*"
                                            class="form-control"  id="guide_dewasa" tabindex=""
                                            name="guide_dewasa" style="display:none"/>
                                </div>
                                <div class="form-group">
                                    <input type="file" autocomplete="off" accept="image/*"
                                            class="form-control"  id="guide_anak" tabindex=""
                                            name="guide_anak" style="display:none"/>
                                </div>
                                <div class="form-group">
                                    <img src="" alt="" style="display:none;width:200px"
                                        onerror="this.src='{{ asset('public/img/no_image.png') }}'"
                                        class="account-profile-image z-depth-1 size-guide-img"/>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-2">Image</div>
                            <div class="col-md-8 mb-3">
                                <div class="dropzone" id="myDropzone">
                                    <div class="dz-message needsclick">
                                    </div>
                                </div>
                                <div id="div-img"></div>
                            </div>
                        </div>
                        <!--<div class="row">
                            <div class="col-md-2">Cara Perawatan</div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <textarea class="form-control summernote "
                                        placeholder="Deskripsi.." id="project_description" tabindex="8"
                                        name="project_description"></textarea>
                                </div>
                            </div>
                        </div>-->
                        <div class="row">
                            <div class="col-md-2">Deskripsi Bahan Baku</div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <textarea class="form-control summernote "
                                        placeholder="Spesifikasi.." id="project_spesification" tabindex="9"
                                        name="project_spesification">{{ old('project_spesification', $spesifikasi) }}</textarea>
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
                    </div>


                </div>
            </div>
        </div>
    </div>


    {{-- <div class="modal fade" id="modal_panduan" data-backdrop="static" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="konveksi-title">Panduan Ukuran </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="form_detail" class="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">

                                </div>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div> --}}

    <script>
        Dropzone.autoDiscover = false;
        $(document).ready(function() {
            // $("#anak").checked(function() {
            //     url: "{{ route('admin.master.project.image.upload') }}",
            //     maxFilesize: 10, // MB
            //     addRemoveLinks: true,
            //     acceptedFiles: 'image/*',
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     },
            // });

            // $('input[name="panduan"]').change(function() {
            //     if($(this).is(':checked')) {
            //         var checked = $(this).val();
            //         console.log
            //         // $('#modal_panduan').modal('show');
            //     }
            // });
            var size_anak = "{{ $size_guide_anak }}";
            var size_dewasa = "{{ $size_guide_dewasa }}";
            if(size_anak != "")
            {
                $('#checkbox_anak').prop('checked', true);
                $('#checkbox_dewasa').prop('checked', false);
                if($('#checkbox_anak').is(':checked')){
                     $("#guide_anak").css('display','block');
                } else {
                    $("#guide_anak").css('display','none');
                }
                $('.size-guide-img').css('display','block');
                $('.size-guide-img').attr("src", size_anak);  
            }
            if(size_dewasa != "")
            {
                $('#checkbox_dewasa').prop('checked', true);
                $('#checkbox_anak').prop('checked', false);
                 if($('#checkbox_dewasa').is(':checked')){
                     $("#guide_dewasa").css('display','block');
                 } else{
                    $("#guide_dewasa").css('display','none');
                 }
                $('.size-guide-img').css('display','block');
                $('.size-guide-img').attr("src", size_dewasa);
            }
            $('#checkbox_anak').click(function(){
                if($(this).prop("checked") == true){
                    $("#guide_anak").css('display','block');
                } else {
                    $("#guide_anak").css('display','none');
                }
            });
            $('#checkbox_dewasa').click(function(){
                if($(this).prop("checked") == true){
                    $("#guide_dewasa").css('display','block');
                } else {
                    $("#guide_dewasa").css('display','none');
                }
            });

            $("#project_price").on('keyup', function() {
                var harga = $("#project_price").autoNumeric("get");
                $("#project_price_hidden").val(harga);
                this.value = parseInt(harga);
            });
            $(".ukuran").each(function() {
                var element = $(this).closest('div.bootstrap-touchspin').find('.ukuran_value');
                var checked = this.checked;
                if(checked) {
                    $(element).prop("disabled", !checked);
                }
                $(this).click(function() {
                    checked = this.checked;
                    $(element).prop("disabled", !checked);
                });
            })

            //dropzone
            var uploadedImageMap = {};
            $("#myDropzone").dropzone({
                url: "{{ route('admin.master.project.image.upload') }}",
                maxFilesize: 2, // MB
                addRemoveLinks: true,
                acceptedFiles: 'image/*',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (file, response) {
                    var res = response;
                    var error = res.errCode;
                    var msg = res.errMsg;
                    if(error == 0) {
                        var data = res.data;
                        var image = data.image_name;
                        $('#div-img').append('<input type="hidden" name="image[]" value="' + image + '">');
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
                        url: "{{ route('admin.master.project.image.delete') }}",
                        data: { file: name },
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        success: function(response) {
                            var msg = response.errMsg;
                            var error = response.errCode;
                            if(error > 0) {
                                $.konveksi.showModal(msg);
                            }
                        },
                    });
                },
                init: function () {
                    @if(isset($image))
                        var files = {!! json_encode($image) !!}
                        for (var i in files) {
                            var file = files[i];
                            var url = files[i].url;
                            this.options.addedfile.call(this, file);
                            this.options.thumbnail.call(this, file, url);
                            this.createThumbnailFromUrl(file, url);
                            $('#div-img').append('<input type="hidden" name="image[]" value="' + files[i].name + '">')
                        }
                    @endif


                }
            });
        });
    </script>
@endsection