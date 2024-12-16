@extends('layouts.admin')

@section('content')
<!-- @include('partials.breadcrumb') -->

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

<!-- State Summary -->
<div class="row">
    <div class="col-xxl-8 col-lg-12">
        <div class="card growth__chart pb-0">
            <div class="card-header flex-grow-1 pb-0">
                <div class="card-header--left">
                    <h4 class="card-title">Leads Growth Chart</h4>
                    <span>(+6%) than last year</span>
                </div>
            </div>
            <div class="card-body">
                <div id="growth_chart"></div>
            </div>
        </div>
    </div>
    <div class="col-xxl-4 col-lg-6">
        <div class="card visitors">
            <div class="card-header flex-grow-1">
                <div class="card-header--left">
                    <h4 class="card-title">Leads Stats</h4>
                </div>
                <span>(+6%) than last year</span>
            </div>
            <div class="card-body">
                <div id="lead_stats"></div>
            </div>
        </div>
    </div>
    <div class="col-xxl-4 col-lg-6">
        <div class="card visitors">
            <div class="card-header flex-grow-1">
                <div class="card-header--left">
                    <h4 class="card-title">Today's Tasks</h4>
                </div>
                <!-- <span>(+6%) than last year</span> -->
            </div>
            <div class="card-body">
                <!-- <div id="lead_stats"></div> -->
            </div>
        </div>
    </div>
    <div class="col-xxl-4 col-lg-6">
        <div class="card visitors">
            <div class="card-header flex-grow-1">
                <div class="card-header--left">
                    <h4 class="card-title">Today's Events</h4>
                </div>
                <!-- <span>(+6%) than last year</span> -->
            </div>
            <div class="card-body">
                <!-- <div id="lead_stats"></div> -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    /*********************************
    /* Line Cart 01 Start
    *********************************/
    if ($("#mini_chart1").length) {
        var options1 = {
            chart: {
                type: "line",
                height: 80,
                sparkline: {
                    enabled: !0,
                },
            },
            series: [{
                data: [3830, 3855, 3845, 3867, 3830],
            }, ],
            stroke: {
                width: 2,
                curve: "smooth",
            },
            markers: {
                size: 0,
            },
            colors: ["#2CD9C5"],
            xaxis: {
                axisTicks: {
                    show: false,
                },
                axisBorder: {
                    show: false,
                },
            },
        };
        new ApexCharts(document.querySelector("#mini_chart1"), options1).render();
    }
    /*********************************
    /* Line Cart 02 Start
    *********************************/
    if ($("#mini_chart2").length) {
        var options2 = {
            chart: {
                type: "line",
                height: 80,
                sparkline: {
                    enabled: !0,
                },
            },
            series: [{
                data: [3830, 3855, 3845, 3850, 3835],
            }, ],
            stroke: {
                width: 2,
                curve: "smooth",
            },
            markers: {
                size: 0,
            },
            colors: ["#FF6C40"],
            xaxis: {
                axisTicks: {
                    show: false,
                },
                axisBorder: {
                    show: false,
                },
            },
        };
        new ApexCharts(document.querySelector("#mini_chart2"), options2).render();
    }
    /*********************************
    /* Line Cart 03 Start
    *********************************/
    if ($("#mini_chart3").length) {
        var options3 = {
            chart: {
                type: "line",
                height: 80,
                sparkline: {
                    enabled: !0,
                },
            },
            series: [{
                data: [3830, 3875, 3830, 3860, 3830],
            }, ],
            stroke: {
                width: 2,
                curve: "smooth",
            },
            markers: {
                size: 0,
            },
            colors: ["#00AB55"],
            xaxis: {
                axisTicks: {
                    show: false,
                },
                axisBorder: {
                    show: false,
                },
            },
        };
        new ApexCharts(document.querySelector("#mini_chart3"), options3).render();
    }
    /*********************************
    /* Line Cart 04 Start
    *********************************/
    if ($("#mini_chart4").length) {
        var options4 = {
            chart: {
                type: "line",
                height: 80,
                sparkline: {
                    enabled: !0,
                },
            },
            series: [{
                data: [3830, 3875, 3855, 3865, 3840],
            }, ],
            stroke: {
                width: 2,
                curve: "smooth",
            },
            markers: {
                size: 0,
            },
            colors: ["#2CD9C5"],
            xaxis: {
                axisTicks: {
                    show: false,
                },
                axisBorder: {
                    show: false,
                },
            },
        };
        new ApexCharts(document.querySelector("#mini_chart4"), options4).render();
    }

    /*********************************
    /* Growth Chart Start
    *********************************/
    if ($("#growth_chart").length) {
        var options5 = {
            series: [{
                    name: "Sales rise",
                    data: [45, 70, 85, 60, 70, 50, 60, 40, 60, 30, 50, 30],
                },
                {
                    name: "Sales drop",
                    data: [15, 40, 55, 30, 40, 20, 30, 10, 35, 70, 55, 60],
                },
            ],
            chart: {
                height: 385,
                type: "area",
                zoom: {
                    enabled: false,
                },
                toolbar: {
                    show: false,
                },
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: "smooth",
                width: 3,
            },
            legend: {
                offsetX: 0,
                offsetY: 15,
                position: "top",
                horizontalAlign: "right",
                floating: false,
                itemMargin: {
                    horizontal: 10,
                    vertical: 10,
                },
            },
            colors: ["#9E77ED", "#EB5E28"],
            xaxis: {
                categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                labels: {
                    show: true,
                    align: "left",
                    style: {
                        colors: "#919EAB",
                        fontSize: "1.2rem",
                        fontFamily: "Inter, sans-serif",
                        fontWeight: 400,
                        cssClass: "apexcharts-yaxis-label",
                    },
                },
                axisTicks: {
                    show: false,
                },
                axisBorder: {
                    show: false,
                },
            },
            yaxis: {
                categories: ["0", "20", "40", "80", "100"],
                labels: {
                    show: true,
                    align: "center",
                    style: {
                        colors: "#7e7e7e",
                        fontSize: "1.2rem",
                        fontFamily: "Roboto, sans-serif",
                        fontWeight: 400,
                        cssClass: "apexcharts-yaxis-label",
                    },
                    offsetX: -10,
                    offsetY: 0,
                },
            },
            tooltip: {
                x: {
                    format: "dd/MM/yy HH:mm",
                },
            },
        };

        new ApexCharts(document.querySelector("#growth_chart"), options5).render();
    }
</script>
<script>
    // Generate JSON data dynamically in PHP
    const leadData = @json($leadStatus);

    if ($("#lead_stats").length) {
        // Convert JSON to a JavaScript-friendly format
        const seriesData = leadData.map(item => item.counts); // Extract 'counts'
        const labelsData = leadData.map(item => item.name); // Extract 'name'

        var options6 = {
            colors: ["#FF0202", "#9E77ED", "#FEDF89", "#0BA5EC"],
            series: seriesData,
            chart: {
                foreColor: "#3d4859",
                type: "donut",
                height: 450,
                parentHeightOffset: 0,
            },
            dataLabels: {
                enabled: true,
                fontSize: "8px",
                fontFamily: "Inter, sans-serif",
                fontWeight: 500,
            },
            plotOptions: {
                pie: {
                    customScale: 1,
                    expandOnClick: true,
                    donut: {
                        size: "50%",
                        labels: {
                            show: true,
                        },
                    },
                },
            },
            labels: labelsData,
            legend: {
                fontSize: "14px",
                fontFamily: "Inter, sans-serif",
                fontWeight: 600,
                position: "bottom",
                width: "100%",
                itemMargin: {
                    horizontal: 0,
                    vertical: 10,
                },
                markers: {
                    radius: 3,
                    width: 10,
                    height: 10,
                    offsetX: 0,
                },
                formatter: function(val, opts) {
                    return [val, "<span>" + opts.w.globals.series[opts.seriesIndex] + "%</span>"];
                },
            },
            stroke: {
                show: false,
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        // width: 200,
                    },
                    legend: {
                        position: "bottom",
                    },
                },
            }, ],
        };

        // Render the chart
        new ApexCharts(document.querySelector("#lead_stats"), options6).render();
    }

</script>
@endsection