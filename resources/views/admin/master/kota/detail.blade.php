@extends('admin.layouts.ec')
@section('title', $title)
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div id="div_back" class="" style="text-align:right;">
                <a id="" href="{{ route('admin.master.kota') }}" class="btn  btn-primary mb-2">
                    <i class="icon icon-fas fa-chevron-left fas fa-chevron-left"></i> Return to Details
                </a>
            </div>
            <div class="ibox ">
                <div class="ibox-title"></div>
                <div class="ibox-content">
                    <form id="form_kota" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-2">Provinsi</div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-control select2" id="province_id" name="province_id">
                                        <option value="" disabled selected>-- All --</option>
                                        <?php
                                        foreach ($province as $k => $v) :
                                            $selected = '';
                                            if (array_get($v, 'id') == $province_id) {
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
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>Nama</label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" style="position:relative">
                                    <input type="text" class="form-control"
                                        placeholder="Nama.." id="name" autocomplete="off"
                                        name="name" value="{{ old('name', $name) }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>Kode</label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" style="position:relative">
                                    <input type="text" class="form-control"
                                        placeholder="Code.." id="code" autocomplete="off"
                                        name="code" value="{{ old('code', $code) }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label>Kode Area</label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group" style="position:relative">
                                    <input type="text" class="form-control"
                                        placeholder="Kode Area.." id="area_code" autocomplete="off"
                                        name="area_code" value="{{ old('area_code', $area_code) }}"/>
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


        });

    </script>
@endsection