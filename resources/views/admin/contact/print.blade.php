@extends('layouts.print')

@section('content')
    <h2>{{ $data->salutation }} {{ $data->name }}</h2>
    <table class="table">
        <tr>
            <td style="width:150px;">{{ __('lang.ContactOwner') }}</td>
            <td>{{ $data->owner != null ? $data->owner->name : '' }}</td>

            <td style="width:150px;">{{ __('lang.AccountName') }}</td>
            <td>{{ $data->account != null ? $data->account->name : '' }}</td>
        </tr>

        <tr>
            <td>{{ __('lang.Name') }}</td>
            <td>{{ $data->salutation }} {{ $data->name }}</td>

            <td>{{ __('lang.Phone') }}</td>
            <td>{{ $data->phone }}</td>
        </tr>

        <tr>
            <td>{{ __('lang.Mobile') }}</td>
            <td>{{ $data->mobile }}</td>

            <td>{{ __('lang.Email') }}</td>
            <td>{{ $data->email }}</td>
        </tr>

        <tr>
            <td>{{ __('lang.Title') }}</td>
            <td>{{ $data->title }}</td>

            <td>{{ __('lang.ReportTo') }}</td>
            <td>{{ $data->parent != null ? $data->parent->name : '' }}</td>
        </tr>
    </table>
    
    <h5 class="head">{{ __('lang.AddressInformation') }}</h5>
    <table class="table">
        <tr>
            <td style="width:150px;">{{ __('lang.MailingAddress') }}</td>
            <td>{{ $data->mailing_street }} {{ $data->mailing_city }} {{ $data->mailing_state }} {{ $data->mailing_postalcode }} {{ $data->mailing_country }}</td>

            <td style="width:150px;">{{ __('lang.OtherAddress') }}</td>
            <td>{{ $data->other_street }} {{ $data->other_city }} {{ $data->other_state }} {{ $data->other_postalcode }} {{ $data->other_country }}</td>
        </tr>
    </table>

    <h5 class="head">{{ __('lang.AdditionalInformation') }}</h5>
    <table class="table">
        <tr>
            <td style="width:150px;">{{ __('lang.Fax') }}</td>
            <td>{{ $data->fax }}</td>

            <td style="width:150px;">{{ __('lang.HomePhone') }}</td>
            <td>{{ $data->phone_home }}</td>
        </tr>
        <tr>
            <td style="width:150px;">{{ __('lang.OtherPhone') }}</td>
            <td>{{ $data->phone_other }}</td>

            <td style="width:150px;">{{ __('lang.AssistantPhone') }}</td>
            <td>{{ $data->phone_assistant }}</td>
        </tr>

        <tr>
            <td>{{ __('lang.Assistant') }}</td>
            <td>{{ $data->assistant }}</td>

            <td>{{ __('lang.Department') }}</td>
            <td>{{ $data->department }}</td>
        </tr>

        <tr>
            <td>{{ __('lang.ContactSource') }}</td>
            <td>{{ $data->source != null ? $data->source->name : '' }}</td>

            <td>{{ __('lang.BirthDay') }}</td>
            <td>{{ $data->birth_date }}</td>
        </tr>

        <tr>                
            <td>{{ __('lang.Description') }}</td>
            <td colspan="3">{{ $data->description }}</td>
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