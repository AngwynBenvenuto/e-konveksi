<?php
    $classContainer = 'col-sm-9';
    $fromCheckout = $from_checkout;
    if ($fromCheckout) {
        $classContainer = 'col-12';
    }

    $same_billing_address = false;

    if (strlen($billing_name) > 0) {
        $same_billing_address = $shipping_name == $billing_name &&
                $shipping_email == $billing_email &&
                $shipping_phone == $billing_phone &&
                $shipping_address == $billing_address &&
                $shipping_province_id == $billing_province_id &&
                $shipping_city_id == $billing_city_id &&
                $shipping_districts_id == $billing_districts_id &&
                $shipping_zipcode == $billing_zipcode;
    }
?>
@extends('front.layouts.ec')
@section('title', $title)
@section('content')
    <div id="section-content" class="page-white page-user py-3">
        <div class="container">
            <nav aria-label="breadcrumb" class="breadcrumbs py-3">
                <?php if (!$fromCheckout): ?>
                    {!! Breadcrumbs::render('user.address') !!}
                <?php else: ?>
                    {!! Breadcrumbs::render('checkout.address.add') !!}
                <?php endif; ?>
            </nav>
        </div>
        <div class="container">
            <div class="row">
                <?php if (!$fromCheckout): ?>
                    <div class="col-sm-3">
                        <?php
                            echo \Lintas\libraries\CBlocks::render('member/account/nav');
                        ?>
                    </div>
                <?php endif; ?>
                <div class=" <?php echo $classContainer; ?> ">	
                    <div class="address-back px-2 mb-4 pt-4 clearfix">
                        <?php if (!$fromCheckout): ?>
                            <a href="{{ route('user.address') }}"><i class="fas fa-chevron-left"></i> <?php echo __('Kembali ke alamat'); ?> </a>
                        <?php else: ?>
                            <a href="{{ route('checkout') }}"><i class="fas fa-chevron-left"></i> <?php echo __('Kemaali ke checkout'); ?> </a>
                        <?php endif; ?>
                        <div class="float-right">
                            <div class="form-group">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" name="same_billing_address" id="same_billing_address" class="checkbox-same-address" value="1">
                                    <span class="">
                                        Data pembeli sama dengan data penerima
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card card-member-content mb-3">
                        <div class=" card-header">
                            <div card-title><?php echo $title; ?></div>
                        </div>
                        <div class="card-body">
                            <?php echo \Lintas\libraries\CBlocks::render('message'); ?>
                            <form id="form_user_address" method="post">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="address-buyer card mb-4">
                                            <div class="card-header">
                                                <div class="address-buyer-title font-weight-bold">
                                                    <?php echo __('Shipping Address'); ?>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="input-field mt-4">
                                                    <label class="active" for="shipping_name"><?php echo __('Nama'); ?></label>
                                                    <input type="text" id="shipping_name" class="form-control" name="shipping_name" value="<?php echo $shipping_name; ?>" autocomplete="off">
                                                </div>
                                                <div class="input-field mt-4">
                                                    <label class="active" for="shipping_email"><?php echo __('Email'); ?></label>
                                                    <input type="email" id="shipping_email" class="form-control" name="shipping_email" value="<?php echo $shipping_email; ?>" autocomplete="off">
                                                </div>
                                                <div class="input-field mt-4">
                                                    <label class="active" for="shipping_phone"><?php echo __('Telepon'); ?></label>
                                                    <input type="text" id="shipping_phone" class="form-control phone" name="shipping_phone" value="<?php echo $shipping_phone; ?>" placeholder="08123233333" autocomplete="off">
                                                </div>
                                                <div class="input-field mt-4">
                                                    <label class="active" for="shipping_address"><?php echo __('Alamat'); ?></label>
                                                    <textarea id="shipping_address" class="form-control" name="shipping_address" class="materialize-textarea" autocomplete="off"><?php echo $shipping_address; ?></textarea>
                                                </div>
                                                <div class="input-field mt-4">
                                                    <select id="shipping_province_id" name="shipping_province_id" class="form-control select2" >
                                                        <option value="" disabled selected><?php echo __('Pilih Provinsi'); ?></option>
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
                                                    <select id="shipping_city_id" name="shipping_city_id" class="form-control select2" >
                                                        <option value="" disabled selected><?php echo __('Pilih Kota'); ?></option>
                                                        <?php
                                                            foreach ($shipping_city as $k => $v) :
                                                                $selected = '';
                                                                if (Arr::get($v, 'id') == $shipping_city_id) {
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
                                                    <select id="shipping_districts_id" name="shipping_districts_id" class="form-control select2" >
                                                        <option value="" disabled selected><?php echo __('Pilih Kabupaten'); ?></option>
                                                        <?php
                                                            foreach ($shipping_districts as $k => $v) :
                                                                $selected = '';
                                                                if (Arr::get($v, 'id') == $shipping_districts_id) {
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
                                                    <label for="shipping_zipcode"><?php echo __('Kodepos'); ?> </label>
                                                    <input type="text" id="shipping_zipcode" name="shipping_zipcode" class="form-control postal" value="<?php echo $shipping_zipcode; ?>" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="address-buyer  card mb-4">
                                            <div class="card-header">
                                                <div class="address-buyer-title font-weight-bold">
                                                    <?php echo __('Billing Address'); ?> 
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="input-field mt-4">
                                                    <label class="active" for="billing_name"><?php echo __('Nama'); ?></label>
                                                    <input type="text" class="form-control" id="billing_name" name="billing_name" value="<?php echo $billing_name; ?>">
                                                </div>
                                                <div class="input-field mt-4">
                                                    <label class="active" for="billing_email"><?php echo __('Email'); ?></label>
                                                    <input type="email" class="form-control" id="billing_email" name="billing_email" value="<?php echo $billing_email; ?>">
                                                </div>
                                                <div class="input-field mt-4">
                                                    <label class="active" for="billing_phone"><?php echo __('Telepon'); ?></label>
                                                    <input type="text" class="form-control" id="billing_phone" name="billing_phone" value="<?php echo $billing_phone; ?>" placeholder="081232333">
                                                </div>
                                                <div class="input-field mt-4">
                                                    <label class="active" for="billing_address"><?php echo __('Alamat'); ?></label>
                                                    <textarea id="billing_address" class="form-control" name="billing_address" class="materialize-textarea"><?php echo $billing_address; ?></textarea>
                                                </div>
                                                <div class="input-field mt-4">
                                                    <select id="billing_province_id" name="billing_province_id" class="form-control select2" >
                                                        <option value="" disabled selected><?php echo __('Pilih Provinsi'); ?></option>
                                                        <?php
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
                                                    <select id="billing_city_id" name="billing_city_id" class="form-control select2" >
                                                        <option value="" disabled selected><?php echo __('Pilih Kota'); ?></option>
                                                        <?php
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
                                                    <select id="billing_districts_id" name="billing_districts_id" class="form-control select2" >
                                                        <option value="" disabled selected><?php echo __('Pilih Kabupaten'); ?></option>
                                                        <?php
                                                        foreach ($billing_districts as $k => $v) :
                                                            $selected = '';
                                                            if (Arr::get($v, 'id') == $billing_districts_id) {
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
                                                    <label for="billing_zipcode"><?php echo __('Kodepos'); ?> </label>
                                                    <input type="text" id="billing_zipcode" name="billing_zipcode" class="form-control" value="<?php echo $billing_zipcode; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="submit" class="border-0 w-100 text-white py-3 btn btn-primary mb-3" value="<?php echo __($title) ?>">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var opt_billing = {
                province_selector: '#billing_province_id',
                city_selector: '#billing_city_id',
                districts_selector: '#billing_districts_id',
                select2: true,
            };
            $.konveksi.provinceControl(opt_billing);
            $.konveksi.cityControl(opt_billing);


            var opt_shipping = {
                province_selector: '#shipping_province_id',
                city_selector: '#shipping_city_id',
                districts_selector: '#shipping_districts_id',
                select2: true,
            };
            $.konveksi.provinceControl(opt_shipping);
            $.konveksi.cityControl(opt_shipping);


        });
    </script>
@endsection