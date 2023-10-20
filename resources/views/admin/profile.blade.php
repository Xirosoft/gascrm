@extends('layouts.admin')

@section('content')
<div class="page-breadcrumb border-bottom">
    <div class="row">
        <div class="col-lg-3 col-md-4 col-xs-12 align-self-center">
            <h5 class="font-medium text-uppercase mb-0">{{ __('lang.MyProfile') }}</h5>
        </div>
    </div>
</div>

<div class="page-content container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ __('lang.Account Details') }}</h4>
                    <form method="POST" action="{{ route('profile') }}" class="needs-validation" novalidate>
                        @csrf

                        <div class="form-group">
                            <label>{{ __('lang.Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="Name" value="{{ Auth::user()->name }}" required>

                            <span class="invalid-feedback">{{ __('lang.isRequired', ['field' => __('lang.Name')]) }}</span>
                            @if ($errors->has('name'))
                                <span class="invalid-feedback d-block">{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>{{ __('lang.Mobile') }} <span class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">+88</span>
                                </div>
                                <input type="text" class="form-control" name="mobile" placeholder="01712xxxxxx" value="{{ Auth::user()->mobile }}" required pattern="[0-9]{11}" title="11 Digit mobile number without country code">
                            </div>

                            <span class="invalid-feedback">{{ __('lang.isRequired', ['field' => __('lang.Mobile')]) }}</span>
                            @if ($errors->has('mobile'))
                                <span class="invalid-feedback d-block">{{ $errors->first('mobile') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>{{ __('lang.Email') }} <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" placeholder="Email address" value="{{ Auth::user()->email }}" required>

                            <span class="invalid-feedback">{{ __('lang.isRequired', ['field' => __('lang.Email')]) }}</span>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback d-block">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <button class="btn btn-secondary btn-rounded btn-block" type="submit">{{ __('lang.Save') }}</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ __('lang.ChangePassword') }}</h4>
                    <form method="POST" action="{{ route('profile.password') }}" class="needs-validation" novalidate>
                        @csrf

                        <div class="form-group">
                            <label>{{ __('lang.CurrentPassword') }} <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="current_password" required>

                            <span class="invalid-feedback">{{ __('lang.isRequired', ['field' => __('lang.CurrentPassword')]) }}</span>
                            @error('current_password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('lang.NewPassword') }} <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" required>

                            <span class="invalid-feedback">{{ __('lang.isRequired', ['field' => __('lang.NewPassword')]) }}</span>
                            @error('password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('lang.ConfirmNewPassword') }} <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password_confirmation" required>

                            <span class="invalid-feedback">{{ __('lang.isRequired', ['field' => __('lang.ConfirmNewPassword')]) }}</span>
                        </div>

                        <button class="btn btn-secondary btn-rounded btn-block" type="submit">{{ __('lang.ChangePassword') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
