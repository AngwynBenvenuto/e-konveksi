@extends('admin.layouts.ec')
@section('title', $title)
@section('content')
    <div class="row">
        <div class="col-12">
            <div id="div_back" class="" style="text-align:right;">
                <a id="" href="{{ route('admin.penjahit.view', $id) }}" class="btn  btn-primary mb-2">
                    <i class="icon icon-fas fa-chevron-left fas fa-chevron-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title"></div>
                <div class="ibox-content">
                    <form id="form_project" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row" style="margin-bottom:10px">
                            <div class="col-md-2">Penjahit</div>
                            <div class="col-md-4">
                                <div class="form-group-static">
                                    <label>{{$penjahit}}</label>
                                </div>
                            </div>
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
                                    <input type="text" autocomplete="off" accept="image/*"
                                        class="form-control"  id="project_video"
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
                                            if(count($array_panduan) > 0) {
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
                        {{-- <div class="row">
                            <div class="col-md-2">Cara Perawatan</div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <textarea class="form-control summernote "
                                        placeholder="Deskripsi.." id="project_description" tabindex="8"
                                        name="project_description">{{ old('project_description', $deskripsi) }}</textarea>
                                </div>
                            </div>
                        </div> --}}
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
                    </form>
                </div>
            </div>
        </div>

    </div>
    <script>
        Dropzone.autoDiscover = false;
        $(document).ready(function() {
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

            $("#project_harga").on('keyup', function() {
                var harga = $("#project_harga").autoNumeric("get");
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
            });
        });
    </script>
@endsection