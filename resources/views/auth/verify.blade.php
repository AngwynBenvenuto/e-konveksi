@extends('front.layouts.ec')
@section('title', $title)
@section('content')
    <div class="page-white py-3">
        <div class="container" class="d-flex align-items-center ">
            <div class="row">
                <?php echo \Lintas\libraries\CBlocks::render('message'); ?>
                
                <div class="col-12 text-center">
                    <div class="row" >
                        <div class="col-md-12 text-center">
                            <img class="img-responsive-verification mx-auto" 
                                    style="width:200px"
                                    src="{{ asset('public/img/centang.png') }}"
                                    onerror="this.src='{{ asset('public/img/no_image.png') }}'"/>
                        </div>
                        <div class="col-md-12" style="font-size: 22px; font-weight: bold; margin: 10px;">
                            <?php echo __('TERIMA KASIH TELAH KONFIRMASI EMAIL ANDA DI '); ?>
                                <span style="color:red;"> <?php echo env('APP_NAME') ?></span>
                        </div>
                        <div class="col-md-12">
                          <p>{{ $message }}</p>
                        </div>
                        <div class="col-sm-12 text-center">
                            <a href="{{ route('login') }}">
                                <button class="btn bg-primary" style="color:#FFF;">
                                    <?php echo __('Ke halaman login'); ?>  
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection