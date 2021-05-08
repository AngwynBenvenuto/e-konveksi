@extends('front.layouts.ec')
@section('title', 'Payment')
@section('content')
    <div id="section-content" class="page-payment py-3">
        <div class="container">
            <nav aria-label="breadcrumb" class="breadcrumbs py-3" >
                {!! Breadcrumbs::render('checkout.payment') !!}
            </nav>
        </div>
        <div class="container">
            <div class="payment-back mb-4 pt-4">
                <a class="btn btn-primary" href="{{ route('checkout.shipping') }}">
                    <i class="fas fa-chevron-left"></i> 
                    <?php echo __('Kembali ke pengiriman'); ?>
                </a>
    
            </div>
            <form id="form_payment" method="post">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        <?php echo \Lintas\libraries\CBlocks::render('payment-choice'); ?>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-header">
                                <?php echo __('Summary'); ?>
                            </div>
                            <div class="card-body">
                                <div class="input-group">
                                </div>

                                <div class="shipping-summary mt-3 mb-3 text-left">
                                    <div class="row no-gutters">
                                        <div class="col text-right"><?php echo __('Subtotal'); ?> </div>
                                        <div class="col-1 text-center">:</div>
                                        <div class="col pl-1">
                                            <span class="invisible">-</span> {{ config('cart.currency') }} <span id="totalitem" data-value="<?php echo 0 ?>"> <?php echo "14,000.00" ?></span>
                                            <input type="hidden" id="total_item" name="total_item" value="" />
                                        </div>
                                    </div>
                                    <div class="row no-gutters font-weight-bold">
                                        <div class="col text-right"><?php echo __('Grand Total'); ?>  </div>
                                        <div class="col-1 text-center">:</div>
                                        <div class="col pl-1">
                                            <span class="invisible">-</span> {{ config('cart.currency') }} <span id="grandtotal"></span>
                                            <input type="hidden" id="grand_total" name="grand_total" value="" />
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="payment-continue border-0 w-100 text-white py-3 btn btn-primary btn-pay">
                                    <?php echo __('Bayar sekarang'); ?>
                                </button>
                            </div>

                        </div>
                    </div>

                </div>
            </form>
        

        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(".btn-pay").click(function(e) {
                e.preventDefault();
                //do ajax
                //if success print invoice n cetak form kerja sama
                return false;
            });
        });




    </script>
@endsection