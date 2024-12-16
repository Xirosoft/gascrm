@extends('layouts.admin')

@section('content')
<div class="page-breadcrumb border-bottom">
    <div class="row">
        <div class="col-lg-3 col-md-4 col-xs-12 align-self-center">
            <h5 class="font-medium text-uppercase mb-0">{{ __('lang.Dashboard') }}</h5>
        </div>
        <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
        </div>
    </div>
</div>

<div class="page-content container-fluid">
    <div class="row">
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-uppercase">New Leads</h5>
                    <div class="d-flex align-items-center mb-2 mt-4">
                        <h2 class="mb-0 display-5"><i class="icon-folder text-primary"></i></h2>
                        <div class="ml-auto">
                            <h2 class="mb-0 display-6"><span class="font-normal">{{ $newLeads }}</span></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-uppercase">All Leads</h5>
                    <div class="d-flex align-items-center mb-2 mt-4">
                        <h2 class="mb-0 display-5"><i class="icon-folder-alt text-danger"></i></h2>
                        <div class="ml-auto">
                            <h2 class="mb-0 display-6"><span class="font-normal">{{ $leadCounts }}</span></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-uppercase">All Accounts</h5>
                    <div class="d-flex align-items-center mb-2 mt-4">
                        <h2 class="mb-0 display-5"><i class="fas fa-sticky-note text-success"></i></h2>
                        <div class="ml-auto">
                            <h2 class="mb-0 display-6"><span class="font-normal">{{ $accountCounts }}</span></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-uppercase">All Contacts</h5>
                    <div class="d-flex align-items-center mb-2 mt-4">
                        <h2 class="mb-0 display-5"><i class="icon-people text-info"></i></h2>
                        <div class="ml-auto">
                            <h2 class="mb-0 display-6"><span class="font-normal">{{ $contactCounts }}</span></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-uppercase">Leads</h5>
                    <div id="morris-donut-chart" style="height:350px;"></div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="d-flex align-items-center p-3">
                    <h5 class="card-title mb-0 text-uppercase">Today's Tasks</h5>
                </div>
                <div class="p-3">
                    <div class="table-responsive">
                        <table class="table text-muted mb-0 no-wrap recent-table font-light">
                            <thead>
                                <tr class="text-uppercase">
                                    <th class="border-0">{{ __('lang.Subject') }}</th>
                                    <th class="border-0">{{ __('lang.RelatedTo') }}</th>
                                    <th class="border-0">{{ __('lang.DueDate') }}</th>
                                    <th class="border-0">{{ __('lang.Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($tasks->count() > 0)
                                @foreach($tasks as $val)
                                <tr>
                                    <td><a href="{{ route('task.show', $val->id) }}">{{ $val->subject }}</a></td>
                                    <td>{{ $val->account != null ? $val->account->name : '' }}</td>
                                    <td>{{ $val->due_date }}</td>
                                    <td>{{ $val->status }}</td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center p-5">{{ __('lang.NoTaskFound') }}</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="d-flex align-items-center p-3">
                    <h5 class="card-title mb-0 text-uppercase">Today's Events</h5>
                </div>
                <div class="p-3">
                    <div class="table-responsive">
                        <table class="table text-muted mb-0 no-wrap recent-table font-light">
                            <thead>
                                <tr class="text-uppercase">
                                    <th class="border-0">{{ __('lang.EndDatetime') }}</th>
                                    <th class="border-0">{{ __('lang.Subject') }}</th>
                                    <th class="border-0">{{ __('lang.Name') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($events->count() > 0)
                                @foreach($events as $val)
                                <tr>
                                    <td>{{ dateFormat($val->end_date, 1) }}</td>
                                    <td><a href="{{ route('event.show', $val->id) }}">{{ $val->subject }}</a></td>
                                    <td>{{ $val->conatctable != null ? $val->conatctable->name : '' }}</td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center p-5">{{ __('lang.NoEventFound') }}</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
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
                @foreach ($leadStatus as $sts)
                {
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