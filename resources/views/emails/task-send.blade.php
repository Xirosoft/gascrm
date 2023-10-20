@extends('layouts.email')

@section('content')
<table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px">
    <tbody>
        <tr>
            <td style="vertical-align: top; padding-bottom:30px;" align="center">
                <a href="{{ route('home') }}" target="_blank">
                    <img src="{{ asset('admin-assets/images/logo.png') }}" alt="{{ env('APP_NAME') }}" style="border:none">
                </a>
            </td>
        </tr>
    </tbody>
</table>
<div style="padding: 40px; background: #fff;">
    <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
        <tbody>
            <tr>
                <td>
                    {!! $task->comment !!}
                    <p>{{ auth()->user()->email_signature }}</p>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection