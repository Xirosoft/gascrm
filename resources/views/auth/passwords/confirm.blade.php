@extends('layouts.admin-auth')

@section('content')

<div class="logo">
    <span class="db"><img src="{{ asset('admin-assets/images/logo.png') }}" alt="logo" /></span>
    <h5 class="font-medium mb-3">{{ __('Confirm Password') }}</h5>
    <span>{{ __('Please confirm your password before continuing.') }}</span>
</div>

<div class="row">
    <div class="col-12">
        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

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

            <div class="form-group text-center">
                <div class="col-xs-12 pb-3">
                    <button class="btn btn-block btn-lg btn-info" type="submit">{{ __('Confirm Password') }}</button>
                </div>
            </div>
            
            @if (Route::has('password.request'))
            <div class="form-group mb-0 mt-2">
                <div class="col-sm-12 text-center">
                    <a href="{{ route('password.request') }}" class="text-info ml-1">{{ __('Forgot Your Password?') }}</a>
                </div>
            </div>
            @endif
        </form>
    </div>
</div>
@endsection
