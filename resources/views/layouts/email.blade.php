<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{ config('app.name', 'sudip.me') }}</title>
</head>
    <body style="margin:0px; background: #f8f8f8; font-family:arial; color: #514d6a;">
        <div width="100%" style="height:100%;  width: 100%; line-height:28px;">
            @yield('content')

            <div style="text-align: center; font-size: 12px; color: #b2b2b5; margin-top: 20px">
                <p>Powered by {{ env('APP_NAME') }}<br></p>
            </div>
        </div>
    </body>
</html>