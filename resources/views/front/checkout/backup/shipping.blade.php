@extends('front.layouts.ec')
@section('title', 'Shipping')
@section('content')
    <div id="section-content" class="page-shipping py-3 page-white">
        <div class="container">
            <nav aria-label="breadcrumb" class="breadcrumbs py-3" >
                {!! Breadcrumbs::render('checkout.shipping') !!}
            </nav>
        </div>
        <div class="container">
            <div class="payment-back mb-4 pt-4">
                <?php
                    $disabledClass = array_get($data,'itemCount') === 0 ? ' disabled' : '';
                ?>
                <a class="btn btn-primary <?php echo $disabledClass; ?>" href="{{ route('checkout.shipping') }}">
                    <i class="fas fa-chevron-left"></i> 
                    <?php echo __('Back to Address'); ?>
                </a>
    
            </div>
            <form id="form_shipping" method="post">
                @csrf

                <div class=" mb-3">
                </div>
                <div class="shipping-summary card pb-3">
                    <div class="card-header">
                        <?php echo __('Summary'); ?>

                    </div>
                    <div class="card-body">
                        <div class="row pl-3">
                            <div class="form-group">
                                <label class="form-check custom-control custom-checkbox">
                                    <input id="dropshipperCheck" class="form-check-input " type="checkbox" value="">
                                    <span class="form-check-label ">
                                        <?php echo __('Send as dropshipper'); ?>
                                    </span>
                                </label>
                            </div>
                            <div class="form-group pl-3" id="pesan">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="col text-center"><?php echo __('Total Product'); ?> :</div>
                                <div class="col text-center"><?php echo 0 ?></div>
                            </div>
                            <div class="col-md-2">
                                <div class="col text-center"><?php echo __('Total'); ?> : </div>
                                <div class="col text-center pl-1">
                                    <span class="invisible">-</span> {{ config('cart.currency') }} <span id="totalitem"></span>
                                    <input type="hidden" id="total_item" name="total_item" value="<?php echo 0 ?>" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="col text-center"><?php echo __('Shipping Cost'); ?> : </div>
                                <div class="col text-center pl-1">
                                    <span class="invisible">-</span> {{ config('cart.currency') }}<span id="totalshipping"></span>
                                    <input type="hidden" id="total_shipping" name="total_shipping" value="" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="col text-center"><?php echo __('Grand Total'); ?> : </div>
                                <div class="col text-center pl-1">
                                    <span class="invisible">-</span> {{ config('cart.currency') }}<span id="grandtotal"></span>
                                    <input type="hidden" id="grand_total" name="grand_total" value="" />
                                </div>
                            </div>
                           
    

                        </div>
                    </div>
                </div>
                <button type="button" class="shipping-continue border-0 w-100 text-white py-3 btn btn-primary mb-3 btn-continue-payment">
                    <?php echo __('Continue To Payment'); ?>
                </button>
                    
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(".btn-continue-payment").click(function(e) {
                e.preventDefault();
                //do ajax
                //if success redirect to payment
                return false;
            });
        });




    </script>
@endsection