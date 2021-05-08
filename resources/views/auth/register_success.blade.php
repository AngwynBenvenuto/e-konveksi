@extends('front.layouts.ec')
@section('title', 'Registration Successfull.')
@section('content')
    <div class="page-white py-3">
        <div class="container" class="d-flex align-items-center ">
            <div class="row">
                <div class="message"></div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <div class="row" >
                        <div class="col-md-12 text-center">
                        <img class="img-responsive-verification mx-auto" 
                                style="width:200px"
                                src="{{ asset('public/img/send-message-logo.png') }}"
                                onerror="this.src='{{ asset('public/img/no_image.png') }}'"/>
                        </div>
                        <div class="col-md-12" style="font-size: 22px; font-weight: bold; margin: 10px;">
                            <?php echo __('TERIMA KASIH TELAH MENDAFTAR DI '); ?>
                                <span style="color:red;"> <?php echo env('APP_NAME') ?></span>
                        </div>
                        <div class="col-md-12" style="font-size: 18px; margin: 10px;">
                            <?php echo __('Segera Konfirmasi Email Anda.'); ?>  <?php echo $email; ?>
                            <br><br>
                        </div>
                        <div class="col-sm-12 text-center">
                            <a href="{{ route('home') }}">
                                <button class="btn bg-primary" style="color:#FFF;">
                                    <?php echo __('Kembali ke home'); ?>  
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
@endsection