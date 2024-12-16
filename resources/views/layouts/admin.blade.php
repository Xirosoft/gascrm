<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admin-assets/images/favicon.ico') }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @include('partials.styles')
    @yield('styles')
</head>

<body>
    <div class="dashboard__mainWrapper">
        @include('partials.sidebar')
        @include('partials.header')

        <!-- Main__container Start-->
        <div class="main__container">
            <!-- Main Inner Wrapper Start -->
            <div class="main__inner--wrapper">
                @yield('content')
            </div>
            <!-- Main Inner Wrapper End -->
        </div>
        <!-- Main__container End-->
    </div>


    @include('partials.scripts')

    <script>
        @if(session('successMessage'))
        Swal.fire({
            title: 'Success!',
            text: "{!! session('successMessage') !!}",
            type: 'success',
            confirmButtonText: 'Ok'
        });

        @elseif(session('errorMessage'))
        Swal.fire({
            title: 'Error!',
            text: "{!! session('errorMessage') !!}",
            type: 'error',
            confirmButtonText: 'Ok'
        });
        @endif
    </script>

    @yield('scripts')

</html>