<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admin-assets/images/favicon.ico') }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('admin-assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/animate.css.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/style.min.css') }}">
    @yield('styles')
</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>


    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url({{ asset('admin-assets/images/auth-bg.jpg') }}) no-repeat center center;">
        <div class="auth-box">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('admin-assets/libs/jquery.min.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/popper.min.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/bootstrap.min.js') }}"></script>
    <script> $(".preloader").fadeOut(); </script>
    @yield('scripts')
</html>
