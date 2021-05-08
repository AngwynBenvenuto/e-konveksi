@extends('front.layouts.ec')
@section('title', $title)
@section('content')
    <div class="page-checkout page-address py-3">
        <div class="container">
            <nav aria-label="breadcrumb" class="breadcrumbs py-3" >
                {!! Breadcrumbs::render('checkout.address') !!}
            </nav>
        </div>
        <div class="container">
            @include('front/checkout/nav/wizard')
        </div>
        <div class="container">
            <?php echo \Lintas\libraries\CBlocks::render('message'); ?>
            <form id="form_address" method="post" action="">
                @csrf
                <div class="address-back px-2 mb-4 clearfix" style="display:none">
                    <div class="float-right">
                        <div class="form-group">
                            <label class="custom-control custom-checkbox">
                                <?php $checked_same_billing_address = $same_billing_address ? ' checked="checked"' : '' ?>
                                <input type="checkbox" name="same_billing_address" id="same_billing_address"
                                    class="checkbox-same-address" value="1" <?php echo $checked_same_billing_address; ?>>
                                <span class="">
                                    Data pembeli sama dengan data penerima
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" style="display:none">
                        <div class="card mb-4">
                            <div class="card-body">
                                @if (!empty($shipping_address))
                                    <div class="input-field mt-4">
                                        <div class="form-group">
                                            <label class="active" for="shipping_address"><?php echo __('Alamat'); ?></label>
                                            <select class="form-control select2" id="shipping_member_address_id"  name="shipping_member_address_id" required="">
                                                <option value="" disabled="" selected> <?php echo __('Choose Address'); ?></option>
                                                @foreach ($shipping_address as $value)
                                                    <option value="<?php echo $value['penjahit_address_id']; ?>">
                                                        <?php echo $value['name']; ?>,
                                                        <?php echo $value['address']; ?>
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <div class="input-field mt-4">
                                        <label class="active" for="shipping_name"><?php echo __('Nama'); ?></label>
                                        <input type="text" id="shipping_name" class="form-control" name="shipping_name" value="">
                                    </div>
                                    <div class="input-field mt-4">
                                        <label class="active" for="shipping_email"><?php echo __('Email'); ?></label>
                                        <input type="email" id="shipping_email" class="form-control" name="shipping_email" value="">
                                    </div>
                                    <div class="input-field mt-4">
                                        <label class="active" for="shipping_address"><?php echo __('Alamat'); ?></label>
                                        <textarea id="shipping_address" class="form-control" name="shipping_address" class="materialize-textarea"></textarea>
                                    </div>
                                    <div class="input-field mt-4">
                                        <label class="active" for="shipping_phone"><?php echo __('Telepon'); ?></label>
                                        <input type="text" id="shipping_phone" class="form-control phone" name="shipping_phone" value=""
                                            placeholder="08123233333">
                                    </div>
                                    <div class="input-field mt-4">
                                        <label class="active" for="shipping_province"><?php echo __('Provinsi'); ?></label>
                                        <select id="shipping_province_id" name="shipping_province_id" class="form-control select2" >
                                            <option value="" disabled selected><?php echo __('Choose Province'); ?></option>
                                            <?php
                                                foreach ($shipping_province as $k => $v) :
                                                    $selected = '';
                                                    if (Arr::get($v, 'id') == $shipping_province_id) {
                                                        $selected = ' selected="selected"';
                                                    }
                                            ?>
                                                <option value="<?php echo Arr::get($v, 'id'); ?>"<?php echo $selected; ?>><?php echo Arr::get($v, 'name'); ?></option>
                                            <?php
                                                endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    <div class="input-field mt-4">
                                        <label class="active" for="shipping_city"><?php echo __('Kota'); ?></label>
                                        <select id="shipping_city_id" name="shipping_city_id" class="form-control select2" >
                                            <option value="" disabled selected><?php echo __('Choose City'); ?></option>
                                            <?php
                                                foreach ($shipping_city as $k => $v) :
                                                    $selected = '';
                                                    if (Arr::get($v, 'id') == $shipping_city_id) {
                                                        $selected = ' selected="selected"';
                                                    }
                                            ?>
                                                    <option value="<?php echo Arr::get($v, 'id'); ?>"<?php echo $selected; ?>><?php echo Arr::get($v, 'name'); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="input-field mt-4">
                                        <label for="shipping_zipcode"><?php echo __('Kodepos'); ?></label>
                                        <input type="text" class="form-control phone" id="shipping_zipcode" name="shipping_zipcode" value="">
                                    </div>
                                @endif




                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="input-field mt-4">
                                    <label class="active" for="billing_name"><?php echo __('Nama Penerima'); ?></label>
                                    <input type="text" class="form-control" id="billing_name" name="billing_name" value="{{ old('billing_name', $name_txt) }}">
                                </div>
                                <div class="input-field mt-4">
                                    <label class="active" for="billing_email"><?php echo __('Email Penerima'); ?></label>
                                    <input type="email" class="form-control" id="billing_email" name="billing_email" value="{{ old('billing_email', $email_txt) }}">
                                </div>
                                <div class="input-field mt-4">
                                    <label class="active" for="billing_address"><?php echo __('Alamat Penerima'); ?></label>
                                    <textarea id="billing_address" class="form-control" name="billing_address" class="materialize-textarea">{{ old('billing_address', $address_txt) }}</textarea>
                                </div>
                                <div class="input-field mt-4">
                                    <label class="active" for="billing_phone"><?php echo __('Telepon Penerima'); ?></label>
                                    <input type="text" class="form-control phone" id="billing_phone" name="billing_phone" value="{{ old('billing_phone', $phone_txt)}}"
                                        placeholder="081232333">
                                </div>
                                <div class="input-field mt-4">
                                    <label class="active" for="billing_province"><?php echo __('Provinsi Penerima'); ?></label>
                                    <select id="billing_province_id" name="billing_province_id" class="form-control select2" >
                                        <option value="" disabled selected><?php echo __('Choose Province'); ?></option>
                                        <?php
                                            if($billing_province_id == null)
                                                $billing_province_id = $province_txt;

                                            foreach ($billing_province as $k => $v) :
                                                $selected = '';
                                                if (Arr::get($v, 'id') == $billing_province_id) {
                                                    $selected = ' selected="selected"';
                                                }
                                        ?>
                                                <option value="<?php echo Arr::get($v, 'id'); ?>"<?php echo $selected; ?>><?php echo Arr::get($v, 'name'); ?></option>
                                        <?php
                                            endforeach;
                                        ?>
                                    </select>
                                </div>
                                <div class="input-field mt-4">
                                    <label class="active" for="billing_city"><?php echo __('Kota Penerima'); ?></label>
                                    <select id="billing_city_id" name="billing_city_id" class="form-control select2" >
                                        <option value="" disabled selected><?php echo __('Choose City'); ?></option>
                                        <?php
                                            if($billing_city_id == null)
                                                $billing_city_id = $city_txt;

                                            foreach ($billing_city as $k => $v) :
                                                $selected = '';
                                                if (Arr::get($v, 'id') == $billing_city_id) {
                                                    $selected = ' selected="selected"';
                                                }
                                        ?>
                                            <option value="<?php echo Arr::get($v, 'id'); ?>"<?php echo $selected; ?>><?php echo Arr::get($v, 'name'); ?></option>
                                        <?php
                                            endforeach;
                                        ?>
                                    </select>
                                </div>
                                <div class="input-field mt-4">
                                    <label for="billing_zipcode"><?php echo __('Kodepos Penerima'); ?></label>
                                    <input type="text" id="billing_zipcode" name="billing_zipcode" class="form-control phone" value="{{ old('billing_zipcode', $zipcode_txt) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">Pilih Data Ikm: </label>
                                    <?php
                                        $ikms = \App\Models\Ikm::where('status', '>', 0)->get();
                                        if($ikms != null) :
                                            foreach($ikms as $ikm) :
                                    ?>
                                        <div class="form-controls-stacked" style="position:relative;margin-top:10px;">
                                            <label class="label-block">
                                                <input name="ikm" type="radio" class="ikm ikm-{{$ikm->id}}" value="{{ $ikm->id }}">&nbsp;{{ $ikm->name }}
                                            </label>
                                        </div>
                                    <?php
                                            endforeach;
                                        endif;
                                    ?>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>
                <button type="submit"
                    class="address-continue border-0 w-100 text-white py-3 btn btn-primary mb-3 btn-continue-shipping">
                    <?php echo __('Lanjut ke metode pembayaran'); ?>
                </button>
            </form>
        </div>

    </div>
    <script>
        $(document).ready(function() {
            var opt = {
                province_selector: '#billing_province_id',
                city_selector: '#billing_city_id',
                select2: true,
            };
            $.konveksi.provinceControl(opt);
            $.konveksi.cityControl(opt);

            $(".ikm").each(function() {
                $(this).click(function() {
                    var ikm_id = this.value;
                    $.ajax({
                        url: "{{ route('api.ikm') }}",
                        data: { ikm_id: ikm_id },
                        dataType: 'json',
                        method: "POST",
                        success: function(response) {
                            if(response.errCode == 0) {
                                var dataIkm = response.data;
                                $("#billing_name").val(dataIkm.name);
                                $("#billing_email").val(dataIkm.email);
                                $("#billing_address").html(dataIkm.address);
                                $("#billing_phone").val(dataIkm.phone);
                                $("#billing_province_id").val(dataIkm.province_id).trigger('change');
                                $("#billing_city_id").val(dataIkm.city_id).trigger('change');
                                $("#billing_zipcode").val(dataIkm.postal_code);
                            }
                        }
                    })
                });
            });
        });
    </script>
@endsection