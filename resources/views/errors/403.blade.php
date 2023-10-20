
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" sizes="16x16" href="{{ asset('admin-assets/images/favicon.ico') }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('admin-assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/animate.css.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/style.min.css') }}">
</head>

<body>
    <div class="main-wrapper">
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <div class="error-box">
            <div class="error-body text-center">
                <img src="{{ asset('admin-assets/images/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}" />
                <h1 class="error-title">403</h1>
                <h3 class="text-uppercase error-subtitle">This action is unauthorized.</h3>
                <a href="{{ route('dashboard') }}" class="btn btn-info btn-rounded waves-effect waves-light mb-5">Back to dashboard</a>
            </div>
        </div>
    </div>
    <script src="{{ asset('admin-assets/libs/jquery.min.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/popper.min.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/bootstrap.min.js') }}"></script>
    <script>
        $('[data-toggle="tooltip"]').tooltip();
        $(".preloader").fadeOut();
    </script>
</body>
</html>