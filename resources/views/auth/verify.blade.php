@extends('layouts.admin-auth')

@section('content')
<div class="logo">
    <span class="db"><img src="{{ asset('admin-assets/images/logo.png') }}" alt="logo" /></span>
    <h5 class="font-medium mb-3">{{ __('Verify Your Email Address') }}</h5>
</div>

<div class="row">
    <div class="col-12 text-justify">
        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif

        {{ __('Before proceeding, please check your email for a verification link.') }}
        {{ __('If you did not receive the email') }},
        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
        </form>
    </div>
</div>
@endsection
