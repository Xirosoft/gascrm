@extends('layouts.print')

@section('content')
    <h2>{{ $data->name }}</h2>
    <table class="table">
        <tr>
            <td style="width:150px;">{{ __('lang.AccountOwner') }}</td>
            <td>{{ $data->owner != null ? $data->owner->name : '' }}</td>

            <td style="width:150px;">{{ __('lang.ParentAccount') }}</td>
            <td>{{ $data->parent != null ? $data->parent->name : 'N/A' }}</td>
        </tr>

        <tr>
            <td>{{ __('lang.Name') }}</td>
            <td>{{ $data->name }}</td>

            <td>{{ __('lang.Mobile') }}</td>
            <td>{{ $data->mobile }}</td>
        </tr>

        <tr>
            <td>{{ __('lang.Fax') }}</td>
            <td>{{ $data->fax }}</td>

            <td>{{ __('lang.Email') }}</td>
            <td>{{ $data->email }}</td>
        </tr>

        <tr>
            <td>{{ __('lang.Website') }}</td>
            <td colspan="3">{{ $data->website }}</td>
        </tr>
    </table>
    
    <h5 class="head">{{ __('lang.AdditionalInformation') }}</h5>
    <table class="table">
        <tr>
            <td style="width:150px;">{{ __('lang.AccountType') }}</td>
            <td>{{ $data->type != null ? $data->type->name : '' }}</td>

            <td style="width:150px;">{{ __('lang.NoOfEmployees') }}</td>
            <td>{{ $data->info_employees }}</td>
        </tr>
        <tr>
            <td style="width:150px;">{{ __('lang.Industry') }}</td>
            <td>{{ $data->industry != null ? $data->industry->name : '' }}</td>

            <td style="width:150px;">{{ __('lang.AnnualRevenue') }}</td>
            <td>{{ $data->info_revenue }}</td>
        </tr>
        <tr>
            <td style="width:150px;">{{ __('lang.Description') }}</td>
            <td colspan="3">{{ $data->description }}</td>
        </tr>
    </table>
    
    <h5 class="head">{{ __('lang.AddressInformation') }}</h5>
    <table class="table">
        <tr>
            <td style="width:150px;">{{ __('lang.BillingAddress') }}</td>
            <td>{{ $data->billing_street }} {{ $data->billing_city }} {{ $data->billing_state }} {{ $data->billing_postalcode }} {{ $data->billing_country }}</td>

            <td style="width:150px;">{{ __('lang.ShippingAddress') }}</td>
            <td>{{ $data->shipping_street }} {{ $data->shipping_city }} {{ $data->shipping_state }} {{ $data->shipping_postalcode }} {{ $data->shipping_country }}</td>
        </tr>
    </table>

    <h5 class="head">{{ __('lang.SystemInformation') }}</h5>
    <table class="table">
        <tr>
            <td style="width:150px;">{{ __('lang.CreatedBy') }}</td>
            <td>{{ $data->creator != null ? $data->creator->name : '' }} - {{ dateFormat($data->created_at, 1) }}</td>

            <td style="width:150px;">{{ __('lang.LastModifiedBy') }}</td>
            <td>{{ $data->editor != null ? $data->editor->name : '' }} - {{ dateFormat($data->updated_at, 1) }}</td>
        </tr>
    </table>
@endsection