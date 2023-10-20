@extends('layouts.print')

@section('content')
    <h2>{{ $data->salutation }} {{ $data->name }}</h2>
    <table class="table">
        <tr>
            <td style="width:150px;">{{ __('lang.LeadOwner') }}</td>
            <td>{{ $data->owner != null ? $data->owner->name : '' }}</td>

            <td style="width:150px;">{{ __('lang.LeadStatus') }}</td>
            <td>{{ $data->lead_status != null ? $data->lead_status->name : '' }}</td>
        </tr>

        <tr>
            <td>{{ __('lang.Name') }}</td>
            <td>{{ $data->salutation }} {{ $data->name }}</td>

            <td>{{ __('lang.Mobile') }}</td>
            <td>{{ $data->mobile }}</td>
        </tr>

        <tr>
            <td>{{ __('lang.Company') }}</td>
            <td>{{ $data->company }}</td>

            <td>{{ __('lang.Email') }}</td>
            <td>{{ $data->email }}</td>
        </tr>

        <tr>
            <td>{{ __('lang.Title') }}</td>
            <td>{{ $data->title }}</td>

            <td>{{ __('lang.Email') }}</td>
            <td>{{ $data->rating != null ? $data->rating->name : '' }}</td>
        </tr>

        <tr>
            <td>{{ __('lang.FollowUp') }}</td>
            <td colspan="3">{{ $data->follow_up == 1 ? 'Yes' : 'No' }}</td>
        </tr>
    </table>
    
    <h5 class="head">{{ __('lang.AddressInformation') }}</h5>
    <table class="table">
        <tr>
            <td style="width:150px;">{{ __('lang.Address') }}</td>
            <td>{{ $data->address_street }} {{ $data->address_city }} {{ $data->address_state }} {{ $data->address_postalcode }} {{ $data->address_country }}</td>

            <td style="width:150px;">{{ __('lang.Website') }}</td>
            <td>{{ $data->website }}</td>
        </tr>
    </table>

    <h5 class="head">{{ __('lang.AdditionalInformation') }}</h5>
    <table class="table">
        <tr>
            <td style="width:150px;">{{ __('lang.NoOfEmployees') }}</td>
            <td>{{ $data->info_employees }}</td>

            <td style="width:150px;">{{ __('lang.LeadSource') }}</td>
            <td>{{ $data->source != null ? $data->source->name : '' }}</td>
        </tr>

        <tr>
            <td>{{ __('lang.AnnualRevenue') }}</td>
            <td>{{ $data->info_revenue }}</td>

            <td>{{ __('lang.Industry') }}</td>
            <td>{{ $data->industry != null ? $data->industry->name : '' }}</td>
        </tr>

        <tr>                
            <td>{{ __('lang.Description') }}</td>
            <td>{{ $data->description }}</td>
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