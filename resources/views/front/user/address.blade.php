<?php
    $billing_addresses = array();
    $shipping_addresses = array();
    if(count($addresses) > 0) {
        foreach ($addresses as $addressesRecord) {
            if (isset($addressesRecord['billing'])) {
                $billing_addresses = $addressesRecord['billing'];
            }

            if (isset($addressesRecord['shipping'])) {
                $shipping_addresses = $addressesRecord['shipping'];
            }
        }
    }
?>
@extends('front.layouts.ec')
@section('title', 'Alamat')
@section('content')
    <div id="section-content" class="page-white page-user pb-3">
        <div class="container">
            <nav aria-label="breadcrumb" class="breadcrumbs py-3">
                {!! Breadcrumbs::render('user.address') !!}
            </nav>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <?php
                        echo \Lintas\libraries\CBlocks::render('member/account/nav');
                    ?>
                </div>
                <div class="col-sm-9">
                    <div class="card card-member-content mb-3">
                        <div class="card-header with-elements">
                            <div class="card-header-title"><?php echo __('Alamat'); ?></div>
                            <div class="card-header-elements ml-md-auto">
                                <a href="{{ route('user.address.create') }}" class="btn btn-lnj pull-right" >
                                    <?php echo __('Tambah Alamat Baru'); ?>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div  class="container-addresses">	
                                <?php echo \Lintas\libraries\CBlocks::render('member/addresses', array('billingAddress' => $billing_addresses, 'shippingAddress' => $shipping_addresses)); ?>
                            </div>
        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection