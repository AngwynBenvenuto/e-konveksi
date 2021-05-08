@extends('admin.layouts.ec')
@section('title', $title)
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div id="div_back" class="" style="text-align:right;">
                <a id="" href="{{ route('admin.master.ikm') }}" class="btn  btn-primary mb-2">
                    <i class="icon icon-fas fa-chevron-left fas fa-chevron-left"></i> Return to Details
                </a>
            </div>
            <div class="ibox ">
                <div class="ibox-title"></div>
                <div class="ibox-content">
                    <form id="" class="form-horizontal" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row-fluid">
                            <div class="span6">
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Nama Lengkap</label>
                                    <div class="controls">
                                        <input type="text" id="name" name="name" class="form-control" autocomplete="off"
                                            value="{{ old('name', $name) }}"/>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Name Display</label>
                                    <div class="controls">
                                        <input type="text" id="name_display" name="name_display" class="form-control"
                                            autocomplete="off" value="{{ old('name_display', $name_display) }}" />
                                    </div>
                                </div>
                                <div class="control-group {{ $errors->has('email') ? ' has-error' : '' }} ">
                                    <label class="form-label control-label">Email</label>
                                    <div class="controls ">
                                        <input type="email" id="email" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                            autocomplete="off" value="{{ old('email', $email) }}" />
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Provinsi</label>
                                    <div class="controls">
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
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Kota/Kabupaten</label>
                                    <div class="controls">
                                        <select class="form-control select2" id="city_id" name="city_id">
                                            <option value="" disabled selected>-- All --</option>
                                            <?php
                                            foreach ($city as $k => $v) :
                                                $selected = '';
                                                if (array_get($v, 'id') == $city_id) {
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
                            <div class="span6">
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Jenis Kelamin</label>
                                    <div class="controls">
                                        <div class="form-controls-stacked" style="position:relative;margin-top:10px;">
                                            <label class="label-block">
                                                <input name="gender" type="radio" id="pria" value="1" <?php echo ($gender != "" && $gender == 1 ? "checked" : '') ?>>&nbsp;Pria&nbsp;&nbsp;&nbsp;
                                                <input name="gender" type="radio" id="wanita" value="0" <?php echo ($gender != "" && $gender == 0 ? "checked" : '') ?>>&nbsp;Wanita
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Nomor Telepon</label>
                                    <div class="controls">
                                        <input type="text" id="phone" name="phone" class="form-control number"
                                            autocomplete="off" value="{{ old('phone', $phone) }}" />
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Tanggal Lahir</label>
                                    <div class="controls">
                                        <input type="text" id="birthdate" name="birthdate" class="form-control date"
                                            autocomplete="off" value="{{ old('birthdate', $birthdate) }}" />
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label id="" class="form-label control-label">Alamat</label>
                                    <div class="controls">
                                        <textarea class="form-control" name="address"
                                            id="address" autocomplete="off" height="130px">{{ old('address', $address) }}</textarea>
                                    </div>
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
    $(document).ready(function(){
        var opt = {
                province_selector: '#province_id',
                city_selector: '#city_id',
                select2: true,
            };
            $.konveksi.provinceControl(opt);
            $.konveksi.cityControl(opt);
    });
    </script>
@endsection