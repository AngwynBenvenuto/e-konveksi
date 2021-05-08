<!DOCTYPE html>
<html class="no-js material-style">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')
    
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('public/favicon.ico') }}" type="image/x-icon"/>
    <link rel="shortcut icon" href="{{ asset('public/favicon.ico') }}" type="image/x-icon"/>
    @include('front/partials/script')
    <style>
        :root {
            --color-body:#fff;
            --color-body-text:#b2b2b2;
            --color-top:#f7f7f7;
            --color-top-text:#333333;
            --color-tabs:#f7f7f7;
            --color-tabs-text:#42b549;
            --color-gray:#f7f7f7;
            --color-gray-text:#333333;
            --color-card-header:#42b549;
            --color-card-header-text:#f7f7f7;
            --color-card-body:#ffffff;
            --color-card-body-text:#7d7d7d;
            --color-highlight:#f7f7f7;
            --color-highlight-text:#333333;
            --color-secondary:#6c7ae0;
            --color-primary:#ff5722;
            --color-primary-text:#f7f7f7;
            --color-konveksi:#6c7ae0;
            --color-primary-dark:#6c7ae0;
            --color-primary-dark-text:#ffff;
            --color-primary-lighter:#ffffff;
            --color-primary-lighter-text:#333333;
            --color-touchspin:#ff5722;
            --color-touchspin-text:#f7f7f7;
            --color-touchspin-border:#ff5722;
            --color-rating:#febf35;
            --color-success:#42b549;
            --color-danger:#d9091a;
            --color-info:#42b549;
            --color-alert-success:#f7f7f7;
            --color-alert-success-border:#42b549;
            --color-alert-success-text:#42b549;
            --color-alert-danger:#f7f7f7;
            --color-alert-danger-border:#d9091a;
            --color-alert-danger-text:#d9091a;
        }
    </style>
    <script type="text/javascript">
        var APP_URL = {!! json_encode(url('/')) !!}
    </script>
</head>
<body class="bg-body">
    <!-- Wrapper-->
    <div id="wrapper">
        @include('front/partials/topnavigation')

        <!-- Main content -->
        <section class="page-container py-3 page-white" style="padding-top:0!important">
            @yield('content')
        </section>
        
        @include('front/partials/footer')

        
    </div>
    
</body>
</html>