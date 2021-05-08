@extends('admin.layouts.ec')
@section('title', 'Profile')
@section('content')
    <div class="row">
        <div class="col-sm-3">
            @include('admin/inc/ikm/side')
        </div>
        <div class="col-sm-9">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Data Setting </h5>
                </div>
                <div class="ibox-content">
                    <form id="form_profile" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-4">
                                <div class="profile-img border p-2">
                                    <div class="img-profile-container ">
                                        <img src="{{ $image_url }}" alt=""
                                            onerror="this.src='{{ asset('public/img/no_image.png') }}'"
                                            class="account-profile-image w-100 z-depth-1"/>
                                    </div>
                                    <div class="img-action-container my-2">
                                        <div class="file-field input-field">
                                            <a href="javascript:;" class="btn btn-primary w-100 btn-update-profile-image">
                                                {{ __('PILIH FOTO') }}
                                            </a>
                                            <input name="image_name" id="input-temp-img" type="file" class="d-none" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Name</label>
                                        <input type="text" class="form-control" tabindex="0"
                                            placeholder="Name.." id="name" autocomplete="off"
                                            name="name" value="{{ old('name', $name) }}"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Name Display</label>
                                        <input type="text" class="form-control" tabindex="1"
                                            placeholder="Name Display.." id="name_display" autocomplete="off"
                                            name="name_display" value="{{ old('name_display', $name_display) }}"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="date_of_birth">{{ __('Tanggal Lahir') }}</label>
                                        <input type="text" class="form-control input date"
                                            name="tanggal_lahir" id="tanggal_lahir" autocomplete="off"
                                            value="{{ old('tanggal_lahir', $tanggal_lahir) }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>{{ __('Jenis Kelamin') }}</label>
                                        <div class="custom-controls-stacked">
                                            <label class="" style="display:block">
                                                <input class="" name="jenis_kelamin" type="radio" id="gender-male" value="1" <?php echo $jenis_kelamin == "1" ? "checked='checked'" : "" ?> >
                                                <span class="">{{ __('Laki-laki') }}</span>
                                            </label>
                                            <label class="" style="display:block">
                                                <input class="" name="jenis_kelamin" type="radio" id="gender-female" value="0" <?php echo $jenis_kelamin == "0" ? "checked='checked'" : "" ?>>
                                                <span class="">{{ __('Perempuan') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="email">{{ __('Email') }}</label>
                                        <label class="form-control text-muted">
                                            {{ $email }}
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Nomor Telepon</label>
                                        <input type="text" class="form-control"
                                            placeholder="Telephone.." id="nomor_telepon" autocomplete="off"
                                            name="nomor_telepon" value="{{ old('nomor_telepon', $nomor_telepon) }}"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-8">
                                        <label class="active" for="address"><?php echo __('Alamat'); ?></label>
                                        <textarea id="address" class="form-control"
                                        name="address" class="materialize-textarea">{{ old('address', $address) }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="active" for="province"><?php echo __('Provinsi'); ?></label>
                                        <select id="province" name="province" class="form-control select2" >
                                            <option value="" disabled selected><?php echo __('Choose Province'); ?></option>
                                            <?php
                                                foreach ($province as $k => $v) :
                                                    $selected = '';
                                                    if (Arr::get($v, 'id') == $province_id) {
                                                        $selected = ' selected="selected"';
                                                    }
                                            ?>
                                                    <option value="<?php echo Arr::get($v, 'id'); ?>"<?php echo $selected; ?>><?php echo Arr::get($v, 'name'); ?></option>
                                            <?php
                                                endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="active" for="city"><?php echo __('Kota'); ?></label>
                                        <select id="city" name="city" class="form-control select2" >
                                            <option value="" disabled selected><?php echo __('Choose City'); ?></option>
                                            <?php
                                                foreach ($city as $k => $v) :
                                                    $selected = '';
                                                    if (Arr::get($v, 'id') == $city_id) {
                                                        $selected = ' selected="selected"';
                                                    }
                                            ?>
                                                <option value="<?php echo Arr::get($v, 'id'); ?>"<?php echo $selected; ?>><?php echo Arr::get($v, 'name'); ?></option>
                                            <?php
                                                endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <button type="submit"
                                        class="w-100 btn btn-primary waves-effect waves-light text-white py-2 w-100">
                                        {{ __('Simpan Perubahan') }}
                                    </button>
                                </div>
                            </div>


                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var opt = {
                province_selector: '#province',
                city_selector: '#city',
                select2: true,
            };
            $.konveksi.provinceControl(opt);
            $.konveksi.cityControl(opt);


            $('.btn-update-profile-image').click(function (evt) {
                $('#input-temp-img').trigger('click');
                return false;
            });
            $('#input-temp-img').change(function (e) {
                var info_width = 748;
                var info_height = 420;
                var cropperWidth = parseFloat(info_width);
                var cropperHeight = parseFloat(info_height);

                $.each(e.target.files, function (i, file) {
                    var reader = new FileReader();
                    reader.onload = function (event) {
                        if (file.type.match('image.*')) {
                            $('.account-profile-image').attr('src', event.target.result);
                        } else {
                            $.konveksi.showModal('Please input correct image type');
                        }
                    }
                    reader.readAsDataURL(file);
                });
            });
        });
    </script>
@endsection