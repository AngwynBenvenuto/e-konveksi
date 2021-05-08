<?php
    use Illuminate\Support\Arr;
    use Lintas\libraries\CBlocks;

    $detailGrouping = Arr::get($data, 'cartItems'); 
?>
@extends('front.layouts.ec')
@section('title', 'Cart')
@section('content')
    <div id="section-content" class="page-cart content2">
        <div class=" container">
            <div class=" page-content-title">	
                {!! __('Keranjang Belanja') !!} 
            </div>
            <div class="row">
                <div class="col-md-12">
                    @include('partials.message')
                </div>
                <div class="col-md-12 text-right py-3">
                    <a href="{{ route('cart.emptyCart') }}" 
                        class="btn btn-primary">
                        <i class="fa fa-trash"></i>
                        &nbsp;&nbsp;Empty Cart
                    </a> 
                    <a href="{{ route('product') }}" class="btn btn-secondary text-white">
                        <i class="fa fa-shopping-cart"></i>
                        &nbsp;&nbsp;Continue Shopping
                    </a>
                </div>
                <div class="col-sm-8">
                    <div class="cart-item-container">
                        <?php
                            echo CBlocks::render('cart/modal/body', array('detailGrouping' => $detailGrouping)); 
                        ?>	
                    </div>
                </div>
                <div class=" cart-summary-container col-sm-4 mb-3">
                    <div class="cart-summary card ">
                        <div class="card-body ">
                            <h6 class="mb-2">{!! __('Ringkasan Pesanan') !!}</h6>
                            <div class="no-gutters mt-4">
                                <?php if (count($detailGrouping) > 0): ?>
                                    <div class="row py-3">
                                        <div class="col text-left font-weight-bold">Tax</div>
                                        <div class="col text-right font-weight-bold">
                                            <span class="invisible">-</span> 
                                                {{ config('cart.currency') }} 
                                            <span id="totalharga">{{ Cart::tax() }}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-left font-weight-bold">Grand Total</div>
                                        <div class="col text-right font-weight-bold">
                                            <span class="invisible">-</span> 
                                                {{ config('cart.currency') }} 
                                            <span id="totalharga">{{ Cart::total() }}</span>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="col text-center"><?php echo __('Tidak ada barang dalam cart'); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="mt-3">
                                <?php if (count($detailGrouping) > 0): ?>
                                    @if(Auth::check())
                                        <a href="javascript:;" 
                                            class="cart-checkout d-block w-100 text-center text-white py-3 btn btn-primary">
                                            <?php echo __('Lanjutkan ke Data Pembeli'); ?>
                                        </a>
                                    @else
                                    <a href="javascript:;" data-login="1" 
                                        class="cart-checkout d-block text-center text-white py-3 btn btn-primary mb-3">
                                        <?php echo __('Masuk sebagai member'); ?>
                                    </a>
                                    @endif
                                <?php else: ?>

                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.cart-checkout').click(function(e) {
                var thisElement = $(this);
                if (ajaxProcess) {
                    ajaxProcess.abort();
                }
                ajaxProcess = $.ajax({
                    type: 'post',
                    dataType: 'json',
                    success: function(response) {
                    },
                    error: function(event, xhr) {
                        if (xhr.status === 0) {
                            if (xhr.statusText === 'abort') {
                                // Has been aborted
                            } else {
                                $.konveksi.showModal('error when check minimum buy');
                            }
                        }
                    },
                    complete: function () {
                        ajaxProcess = null;
                    },
                })
            });



        });

    </script>
@endsection