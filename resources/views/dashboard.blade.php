@extends('layouts.admin')

@section('content')
@include('partials.breadcrumb')

<!-- State Summary -->
<div class="state__summary">
    <div class="row">
        <div class="col-xxl-3 col-xl-3 col-sm-6">
            <div class="stateBox">
                <div class="stateBox__content">
                    <h5 class="title">New Leads</h5>
                    <div class="counter__value">{{ $newLeads }}</div>
                    <div class="text__group">
                        <div class="progres">
                            <svg width="14" height="8" viewBox="0 0 14 8" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12.9992 0.666667C13.0055 0.620213 13.0055 0.57312 12.9992 0.526667C12.9934 0.487526 12.9822 0.449383 12.9659 0.413333C12.9483 0.380752 12.9282 0.349551 12.9059 0.32C12.8805 0.277835 12.8491 0.239646 12.8126 0.206667L12.7326 0.16C12.6941 0.131304 12.6513 0.10881 12.6059 0.0933333H12.4726C12.4319 0.0539967 12.3845 0.0223717 12.3326 0H8.99922C8.63103 0 8.33256 0.298477 8.33256 0.666667C8.33256 1.03486 8.63103 1.33333 8.99922 1.33333H10.8859L8.21922 4.47333L5.33922 2.76C5.05741 2.59239 4.69556 2.65458 4.48589 2.90667L1.15256 6.90667C1.03918 7.04272 0.984605 7.2183 1.00086 7.39465C1.01712 7.571 1.10288 7.73363 1.23922 7.84667C1.35916 7.94605 1.51012 8.0003 1.66589 8C1.86418 8.00032 2.05232 7.91236 2.17922 7.76L5.14589 4.2L7.99256 5.90667C8.27129 6.07199 8.62854 6.01292 8.83922 5.76667L11.6659 2.46667V4C11.6659 4.36819 11.9644 4.66667 12.3326 4.66667C12.7007 4.66667 12.9992 4.36819 12.9992 4V0.666667Z"
                                    fill="#54D62C" />
                            </svg>
                        </div>
                        <div class="content"><span>+0.36%</span> than last week</div>
                    </div>
                </div>
                <div class="Minichart">
                    <div id="mini_chart1"></div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-3 col-sm-6">
            <div class="stateBox">
                <div class="stateBox__content">
                    <h5 class="title">Total Leads</h5>
                    <div class="counter__value">{{ $leadCounts }}</div>
                    <div class="text__group">
                        <div class="progres bg-danger">
                            <svg width="12" height="8" viewBox="0 0 12 8" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12.0008 3.99999C12.0008 3.6318 11.7024 3.33333 11.3342 3.33333C10.966 3.33333 10.6675 3.6318 10.6675 3.99999V5.53333L7.84084 2.19999C7.63016 1.95374 7.27291 1.89467 6.99418 2.05999L4.14751 3.79999L1.18084 0.239993C1.02841 0.0565964 0.789714 -0.0315466 0.554671 0.00876633C0.319629 0.0490793 0.123947 0.211724 0.0413378 0.435433C-0.0412714 0.659142 0.00174203 0.90993 0.154175 1.09333L3.48751 5.09333C3.69718 5.34541 4.05903 5.4076 4.34084 5.23999L7.19418 3.52666L9.86084 6.66666H8.00084C7.63265 6.66666 7.33418 6.96514 7.33418 7.33333C7.33418 7.70152 7.63265 7.99999 8.00084 7.99999H11.3342C11.4162 7.99798 11.4974 7.9822 11.5742 7.95333L11.6675 7.89999C11.7023 7.88247 11.7357 7.86242 11.7675 7.83999C11.804 7.80701 11.8355 7.76882 11.8608 7.72666C11.8832 7.69711 11.9032 7.66591 11.9208 7.63333C11.9372 7.59728 11.9484 7.55913 11.9542 7.51999C11.9812 7.46122 11.997 7.39791 12.0008 7.33333V3.99999Z"
                                    fill="#FF4842" />
                            </svg>
                        </div>
                        <div class="content"><span>-2.1%</span> than last week</div>
                    </div>
                </div>
                <div class="Minichart">
                    <div id="mini_chart2"></div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-3 col-sm-6">
            <div class="stateBox">
                <div class="stateBox__content">
                    <h5 class="title">Total Accounts</h5>
                    <div class="counter__value">{{ $accountCounts }}</div>
                    <div class="text__group">
                        <div class="progres">
                            <svg width="14" height="8" viewBox="0 0 14 8" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12.9992 0.666667C13.0055 0.620213 13.0055 0.57312 12.9992 0.526667C12.9934 0.487526 12.9822 0.449383 12.9659 0.413333C12.9483 0.380752 12.9282 0.349551 12.9059 0.32C12.8805 0.277835 12.8491 0.239646 12.8126 0.206667L12.7326 0.16C12.6941 0.131304 12.6513 0.10881 12.6059 0.0933333H12.4726C12.4319 0.0539967 12.3845 0.0223717 12.3326 0H8.99922C8.63103 0 8.33256 0.298477 8.33256 0.666667C8.33256 1.03486 8.63103 1.33333 8.99922 1.33333H10.8859L8.21922 4.47333L5.33922 2.76C5.05741 2.59239 4.69556 2.65458 4.48589 2.90667L1.15256 6.90667C1.03918 7.04272 0.984605 7.2183 1.00086 7.39465C1.01712 7.571 1.10288 7.73363 1.23922 7.84667C1.35916 7.94605 1.51012 8.0003 1.66589 8C1.86418 8.00032 2.05232 7.91236 2.17922 7.76L5.14589 4.2L7.99256 5.90667C8.27129 6.07199 8.62854 6.01292 8.83922 5.76667L11.6659 2.46667V4C11.6659 4.36819 11.9644 4.66667 12.3326 4.66667C12.7007 4.66667 12.9992 4.36819 12.9992 4V0.666667Z"
                                    fill="#54D62C" />
                            </svg>
                        </div>
                        <div class="content"><span>9.45%</span> than last week</div>
                    </div>
                </div>
                <div class="Minichart">
                    <div id="mini_chart3"></div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-3 col-sm-6">
            <div class="stateBox">
                <div class="stateBox__content">
                    <h5 class="title">Total Contacts</h5>
                    <div class="counter__value">{{ $contactCounts }}</div>
                    <div class="text__group">
                        <div class="progres bg-danger">
                            <svg width="12" height="8" viewBox="0 0 12 8" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12.0008 3.99999C12.0008 3.6318 11.7024 3.33333 11.3342 3.33333C10.966 3.33333 10.6675 3.6318 10.6675 3.99999V5.53333L7.84084 2.19999C7.63016 1.95374 7.27291 1.89467 6.99418 2.05999L4.14751 3.79999L1.18084 0.239993C1.02841 0.0565964 0.789714 -0.0315466 0.554671 0.00876633C0.319629 0.0490793 0.123947 0.211724 0.0413378 0.435433C-0.0412714 0.659142 0.00174203 0.90993 0.154175 1.09333L3.48751 5.09333C3.69718 5.34541 4.05903 5.4076 4.34084 5.23999L7.19418 3.52666L9.86084 6.66666H8.00084C7.63265 6.66666 7.33418 6.96514 7.33418 7.33333C7.33418 7.70152 7.63265 7.99999 8.00084 7.99999H11.3342C11.4162 7.99798 11.4974 7.9822 11.5742 7.95333L11.6675 7.89999C11.7023 7.88247 11.7357 7.86242 11.7675 7.83999C11.804 7.80701 11.8355 7.76882 11.8608 7.72666C11.8832 7.69711 11.9032 7.66591 11.9208 7.63333C11.9372 7.59728 11.9484 7.55913 11.9542 7.51999C11.9812 7.46122 11.997 7.39791 12.0008 7.33333V3.99999Z"
                                    fill="#FF4842" />
                            </svg>
                        </div>
                        <div class="content"><span>-5.09%</span> than last week</div>
                    </div>
                </div>
                <div class="Minichart">
                    <div id="mini_chart4"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('admin-assets/charts/morris.js/morris.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('admin-assets/charts/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('admin-assets/charts/morris.js/morris.min.js') }}"></script>
<script>
    Morris.Donut({
        element: 'morris-donut-chart',
        data: [
            @foreach($leadStatus as $sts) {
                label: '{{ $sts->name }}',
                value: '{{ $sts->counts }}'
            },
            @endforeach
        ],
        resize: true,
        colors: ['#ff7676', '#2cabe3', '#53e69d', '#7bcef3']
    });
</script>
@endsection