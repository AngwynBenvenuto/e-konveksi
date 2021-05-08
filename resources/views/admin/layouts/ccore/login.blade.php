<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name='keywords' content='' />
    <meta name='description' content='' />
    <meta name='Author' content='' />
    <title>Administrator | Login</title>
    <link rel="icon" href="{{ asset('public/favicon.ico') }}" type="image/x-icon"/>
    <link rel="shortcut icon" href="{{ asset('public/favicon.ico') }}" type="image/x-icon"/>
    @include('admin.inc.script')
</head>
<body class="bg-white">
    <div id="page-container">
        <div class="login login-with-news-feed">
            <div class="news-feed">
                <div class="news-image" 
                    style="background:#1ab394 url('{{ asset('public/img/banner.jpg') }}') no-repeat center center;
                            background-size:cover;object-fit:contain;width:100%;height:100%"></div>
                <div class="news-caption">
                    <h4 class="caption-title"><b></b> </h4>
                    <p></p>
                </div>
            </div>
            <div class="right-content">
                <div class="login-header">
                    <div class="brand">
                        <span>{{ __(env('APP_NAME')) }}</span>
                        <small>{{ __('Administrator Area') }}</small>
                    </div>
                </div>
                <div class="login-content" id="container">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    
    <!-- modal -->
    <div id="modal_forgot_password" class="modal fade" style="width: 400px; margin: auto" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInDown">
                <div class="modal-header">
                    <h3>{{ __('Forgot Password') }}</h3>
                </div>
                <div class="modal-body">
                    <div class="modal-info">
                        <div class="alert alert-warning modal-info-loading" style="display: none;">L o a d i n g . . .</div>
                        <div class="alert alert-danger modal-info-msg" style="display: none;"></div>
                    </div>
                    <p>{{ __('Please enter your username to get a new password?') }}</p>
                    <input type="text" class="form-control" id="username_forgot" name="username_forgot" style="width:97%;">
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</a>
                    <a href="#" class="btn btn-danger btn-reset-password">{{ __('Reset Password') }}</a>
                </div>
            </div>
        </div>
    </div>
    <div id="modal_forgot_ok" class="modal" style="width:400px;margin:auto;">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInDown">
                <div class="modal-header">
                    <h3>{{ __('Forgot Password') }}</h3>
                </div>
                <div class="modal-body">
                    <p>
                        {{ __('Sebuah email telah dikirim ke alamat email Anda,') }}
                        <span class="email-forgot-ok"></span>
                    </p>
                    <p>	
                        {{ __('Email ini berisikan cara untuk mendapatkan password baru.') }}<br>
                        {{ __('Diharapkan menunggu beberapa saat, selama pengiriman email dalam proses. ') }}
                        <br>
                        {{ __('Mohon diperhatikan bahwa alamat email diatas adalah benar, dan periksalah folder junk dan spam atau filter jika tidak menerima email tersebut.') }}                      
                    </p>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">{{ __('Close') }}</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(document).on('keypress',function(e) {
                if(e.which == 13) {
                    $('#form-login').submit();
                }
            });

            $(".btn-forgot-password").click(function () {
                $('#email_forgot').val('');
                $('#modal_forgot_password').modal('show');
                $('.modal-info-loading').hide();
                $('.modal-info-msg').hide();
            });

            $('.modal-info-msg').hide();
            $('.modal-info-loading').hide();
            $('.btn-reset-password').click(function (e) {
                e.preventDefault();
                $('.modal-info-msg').hide();
                $('.modal-info-loading').show('fast');
                $.ajax({
                    url: "{{ route('admin.forgot') }}",
                    dataType: "json",
                    data: {
                        username: $('#username_forgot').val()
                    },
                    success: function (response) {
                        var err_code = response.errCode;
                        var err_message = response.errMsg;
                        if (err_code > 0) {
                            $('.modal-info-loading').hide('fast');
                            $('.modal-info-msg').html(err_message);
                            $('.modal-info-msg').show('fast');
                        } else {
                            $('.email-forgot-ok').html(response.email);
                            $('#modal_forgot_password').modal('hide');
                            $('#modal_forgot_ok').modal('show');
                        }
                    }
                });
                return false;
            });
        });
    </script> 
</body>
</html>