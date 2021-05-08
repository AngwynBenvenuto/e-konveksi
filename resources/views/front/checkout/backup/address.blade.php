@extends('front.layouts.ec')
@section('title', 'Address')
@section('content')
    <div class="page-checkout page-address py-3">
        <div class="container">
            <nav aria-label="breadcrumb" class="breadcrumbs py-3" >
                {!! Breadcrumbs::render('checkout.address') !!}
            </nav>
        </div>
        <div class="container">
            <?php echo \Lintas\libraries\CBlocks::render('message'); ?>
            <form id="form_address" method="post" action="{{ route('checkout.address.store') }}">
                @csrf
                
                <div class="address-back px-2 mb-4 pt-4 clearfix">
                    <a href="">
                        <i class="fas fa-chevron-left"></i>
                        Back 
                    </a>
                    @if(Auth::check())
                    @else
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
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="address-buyer card mb-4">
                            <div class="card-header">
                                <div class="address-buyer-title font-weight-bold">
                                    {{ __('Shipping Address') }}
                                </div>
                            </div>
                            <div class="card-body">
                                @if(Auth::check())
                                    <div class="input-field mt-4">
                                        <div class="form-group">
                                            @if (!empty($shipping_address))
                                                <select class="form-control select2" id="shipping_member_address_id"  name="shipping_member_address_id" required="">
                                                    <option value="" disabled="" selected> <?php echo __('Choose Address'); ?></option>
                                                    @foreach ($shipping_address as $value)
                                                        <option value="<?php echo $value['member_address_id']; ?>">
                                                            <?php echo $value['name']; ?>,
                                                            <?php echo $value['address']; ?>
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <p>
                                                    <?php echo __('Shipping address is empty'); ?>
                                                </p>
                                                <?php echo __('Please add new address to continue'); ?>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="input-field mt-4">
                                        <label class="active" for="shipping_name"><?php echo __('Name'); ?></label>
                                        <input type="text" id="shipping_name" class="form-control" name="shipping_name" value="">
                                    </div>
                                    <div class="input-field mt-4">
                                        <label class="active" for="shipping_email"><?php echo __('Email'); ?></label>
                                        <input type="email" id="shipping_email" class="form-control" name="shipping_email" value="">
                                    </div>
                                    <div class="input-field mt-4">
                                        <label class="active" for="shipping_address"><?php echo __('Address'); ?></label>
                                        <textarea id="shipping_address" class="form-control" name="shipping_address" class="materialize-textarea"></textarea>
                                    </div>
                                    <div class="input-field mt-4">
                                        <label class="active" for="shipping_phone"><?php echo __('Phone'); ?></label>
                                        <input type="text" id="shipping_phone" class="form-control" name="shipping_phone" value="" 
                                            placeholder="08123233333">
                                    </div>
                                    <div class="input-field mt-4">
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
                                        <select id="shipping_districts_id" name="shipping_districts_id" class="form-control select2" >
                                            <option value="" disabled selected><?php echo __('Choose District'); ?></option>
                                            <?php
                                                foreach ($shipping_districts as $k => $v) :
                                                    $selected = '';
                                                    if (Arr::get($v, 'id') == $shipping_districts_id) {
                                                        $selected = ' selected="selected"';
                                                    }
                                            ?>
                                                <option value="<?php echo Arr::get($v, 'id'); ?>"<?php echo $selected; ?>><?php echo Arr::get($v, 'name'); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="input-field mt-4">
                                        <label for="shipping_zipcode"><?php echo __('Postal Code'); ?></label>
                                        <input type="text" class="form-control" id="shipping_zipcode" name="shipping_zipcode" value="">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="address-buyer card mb-4">
                            <div class="card-header">
                                <div class="address-buyer-title font-weight-bold">
                                    <?php echo __('Billing Address'); ?>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(Auth::check())
                                    <div class="input-field mt-4">
                                        <div class="form-group">
                                            @if (!empty($billing_address))
                                                <select class="form-control select2" id="billing_member_address_id"  name="billing_member_address_id" required="">
                                                    <option value="" disabled="" selected> <?php echo __('Choose Address'); ?></option>
                                                    @foreach ($billing_address as $value)
                                                        <option value="<?php echo $value['member_address_id']; ?>">
                                                            <?php echo $value['name']; ?>,
                                                            <?php echo $value['address']; ?>
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <p>
                                                    <?php echo __('Billing address is empty'); ?>
                                                </p>
                                                <?php echo __('Please add new address to continue'); ?>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="input-field mt-4">
                                        <label class="active" for="billing_name"><?php echo __('Name'); ?></label>
                                        <input type="text" class="form-control" id="billing_name" name="billing_name" value="">
                                    </div>
                                    <div class="input-field mt-4">
                                        <label class="active" for="billing_email"><?php echo __('Email'); ?></label>
                                        <input type="email" class="form-control" id="billing_email" name="billing_email" value="">
                                    </div>
                                    <div class="input-field mt-4">
                                        <label class="active" for="billing_phone"><?php echo __('Phone'); ?></label>
                                        <input type="text" class="form-control" id="billing_phone" name="billing_phone" value="" 
                                            placeholder="081232333">
                                    </div>
                                    <div class="input-field mt-4">
                                        <label class="active" for="billing_address"><?php echo __('Address'); ?></label>
                                        <textarea id="billing_address" class="form-control" name="billing_address" class="materialize-textarea"></textarea>
                                    </div>
                                    <div class="input-field mt-4">
                                        <select id="billing_province_id" name="billing_province_id" class="form-control select2" >
                                            <option value="" disabled selected><?php echo __('Choose Province'); ?></option>
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
                                            <option value="" disabled selected><?php echo __('Choose City'); ?></option>
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
                                            <option value="" disabled selected><?php echo __('Choose District'); ?></option>
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
                                        <label for="billing_zipcode"><?php echo __('Postal Code'); ?></label>
                                        <input type="text" id="billing_zipcode" name="billing_zipcode" class="form-control" value="">
                                    </div>
        
                                @endif
                            </div>
                        </div>
                    </div>

                    <?php if (Auth::check()): ?>
                        <a href="{{ url('address/create?ref=checkout') }}" class="border-0 w-100 text-white py-3 btn btn-primary-dark mb-3"> <?php echo __('Add New Address'); ?> </a>
                    <?php endif; ?>
                    <button type="button" 
                        class="address-continue border-0 w-100 text-white py-3 btn btn-primary mb-3 btn-continue-shipping">
                        <?php echo __('Continue to Shipping'); ?>
                    </button>


                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(".btn-continue-shipping").click(function(e) {
                e.preventDefault();
                //do ajax
                //if success redirect to shipping
                return false;
            });
        });




    </script>
@endsection