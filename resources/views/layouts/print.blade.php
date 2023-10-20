<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <style>
        @media screen, print {
            body {
                background: #fff;
                font-family: Rubik, sans-serif;
                font-size: .875rem;
                line-height: 1.5;
                margin: 0;
                padding: 20px;
            }
            .container-fluid {
                width: 100%;
            }
            .header {
                width: 100%;
                clear: both;
            }
            .header .logo {
                float: left;
                width: 100px;
            }
            .header .rightSide {
                float: right;
            }
            .header .rightSide ul {
                margin: 0;
                padding: 0;
            }
            .header .rightSide ul li a {
                color: #000;
                font-size: 12px;
            }
            .content {
                width: 100%;
                clear: both;
                padding-top: 10px;
            }
            .h2, h2 {
                font-size: 1.5rem;
            }
            .h5, h5 {
                font-size: .875rem;
            }
            .head {
                background-color: #eee;
                border-color: #eee;
                padding: 4px 3px;
                margin-bottom: 0;
            }
            .table {
                width: 100%;
                margin-bottom: 1rem;
                
            }
            .table td, .table th {
                padding: 5px 5px;
                vertical-align: top;
                border: 0;
            }
        }

        @media print {
            .header .rightSide {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="header">
            <img src="{{ asset('admin-assets/images/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}" class="logo" />
            <div class="rightSide">
                <ul>
                    <li><a href="javascript:window.close();">Close Window</a></li>
                    <li><a href="javascript:window.print();">Print This Page</a></li>
                </ul>
            </div>
        </div>

        <div class="content">
        @yield('content')
        </div>
    </div>
</body>
</html>
