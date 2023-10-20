@extends('layouts.admin-auth')

@section('content')
<div class="logo">
    <span class="db"><img src="{{ asset('admin-assets/images/logo.png') }}" alt="logo" /></span>
    <h5 class="font-medium mb-3">{{ __('Create an account') }}</h5>
</div>

<div class="row">
    <div class="col-12">
        <form class="form-horizontal mt-3" method="POST" action="{{ route('register') }}">
            @csrf

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                </div>
                <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" required value="{{ old('name') }}" placeholder="Name" autocomplete="name">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
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
                    <span class="input-group-text"><i class="fa fa-mobile"></i></span>
                </div>
                <input type="text" class="form-control form-control-lg @error('mobile') is-invalid @enderror" name="mobile" required value="{{ old('mobile') }}" placeholder="Contact Person Mobile Number" autocomplete="mobile">
                @error('mobile')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-key"></i></span>
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
                    <span class="input-group-text"><i class="fa fa-key"></i></span>
                </div>
                <input type="password" class="form-control form-control-lg" name="password_confirmation" required placeholder="Confirm Password" autocomplete="current-password">
            </div>

            <div class="form-group row">
                <div class="col-md-12 ">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" required class="custom-control-input" id="customCheck1">
                        <label class="custom-control-label" for="customCheck1">{{ __('I have read and agreed with') }} <a href="javascript:void(0)">{{ __('Terms of service') }}</a></label>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="col-xs-12 pb-3">
                    <button class="btn btn-block btn-lg btn-info" type="submit">{{ __('Create an account') }}</button>
                </div>
            </div>
            
            <div class="form-group mb-0 mt-2">
                <div class="col-sm-12 text-center">
                    {{ __('Already have an account?') }} <a href="{{ route('login') }}" class="text-info ml-1">{{ __('Sign in') }}</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
