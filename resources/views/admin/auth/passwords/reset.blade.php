@extends('layouts.admin-auth')

@section('content')
<div class="logo">
    <span class="db"><img src="{{ asset('admin-assets/images/logo.png') }}" alt="logo" /></span>
    <h5 class="font-medium mb-3">{{ __('Reset Password') }}</h5>
</div>

<div class="row">
    <div class="col-12">
        <form class="form-horizontal mt-3" method="POST" action="{{ route('admin.password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="ti-email"></i></span>
                </div>
                <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" required value="{{ old('email') }}" placeholder="Email" autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="ti-pencil"></i></span>
                </div>
                <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required placeholder="Password" autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="ti-pencil"></i></span>
                </div>
                <input type="password" class="form-control form-control-lg" name="password_confirmation" required placeholder="Confirm Password" autocomplete="current-password">
            </div>

            <div class="form-group text-center">
                <div class="col-xs-12 pb-3">
                    <button class="btn btn-block btn-lg btn-info" type="submit">{{ __('Reset Password') }}</button>
                </div>
            </div>
            
            <div class="form-group mb-0 mt-2">
                <div class="col-sm-12 text-center">
                    {{ __('Back to') }} <a href="{{ route('admin.login') }}" class="text-info ml-1">{{ __('Sign in') }}</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
