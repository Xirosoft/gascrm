@extends('layouts.admin-auth')

@section('content')
<div class="logo">
    <span class="db"><img src="{{ asset('admin-assets/images/logo.png') }}" alt="logo" /></span>
    {{-- <h5 class="font-medium mb-3">{{ __('Sign In') }}</h5> --}}
</div>

<div class="row">
    <div class="col-12">
        <form class="form-horizontal mt-3" method="POST" action="{{ route('login') }}">
            @csrf

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
                    <span class="input-group-text"><i class="fa fa-key"></i></span>
                </div>
                <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required placeholder="Password" autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group row">
                <div class="col-md-12">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="remember">{{ __('Remember me') }}</label>

                        @if (Route::has('password.request'))
                            <a class="text-dark float-right" href="{{ route('password.request') }}">
                                <i class="fa fa-lock mr-1"></i> {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="col-xs-12 pb-3">
                    <button class="btn btn-block btn-lg btn-info" type="submit">{{ __('Sign in') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
