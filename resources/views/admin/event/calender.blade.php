@extends('layouts.admin')

@section('content')
        <div class="page-breadcrumb border-bottom">
            <div class="row">
                <div class="col-lg-3 col-md-2 col-12 align-self-center">
                    <h5 class="font-medium text-uppercase mb-0">
                        {{ __('lang.Events') }}
                    </h5>
                </div>
                <div class="col-lg-9 col-md-10 col-12 align-self-center">
                    
                    <form method="GET" action="{{ route('event.calender') }}" class="search-form">
                        <div class="form-group mx-md-2 mb-2">
                            <input type="text" class="form-control input-outline-secondary" name="q" value="{{ Request::get('q') }}" placeholder="{{ __('lang.InputSearchText') }}">
                        </div>

                        <div class="btn-group mb-2">
                            <button type="submit" class="btn btn-secondary"><i class="fa fa-search"></i> {{ __('lang.Search') }}</button>
                            <a href="{{ route('event.calender') }}" class="btn btn-secondary"><i class="fa fa-times"></i></a>
                            @can('add event') 
                            <a class="btn btn-secondary ml-2" href="javascript:void(0);" @click="$refs.childref.addModal('{{ route('event.store').qString() }}')"><i class="fa fa-plus"></i></a>
                            @endcan
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="page-content container-fluid">
            <div class="card">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

        <!-- Store/Update Modal -->
        @if(auth()->user()->can('add event') || auth()->user()->can('edit event'))
        <event-form ref="childref" page="{{ Request::routeIs('event.create') ? 'create' : 'index' }}" :user="{{ Auth::user() }}" :urls="{ 
            options : '{{ route('api-options') }}', 
            event : '{{ route('event.index') }}', 
            store : '{{ route('event.store') }}'
        }"></event-form>
        @endif
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('admin-assets/libs/fullcalendar/fullcalendar.min.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('admin-assets/libs/fullcalendar/moment.min.js') }}"></script>
<script src="{{ asset('admin-assets/libs/fullcalendar/fullcalendar.min.js') }}"></script>
<script>
    $('#calendar').fullCalendar({
        slotDuration: '01:00:00', 
        defaultView: 'month',  
        handleWindowResize: true,   
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: function(start, end, timezone, callback) {
            jQuery.ajax({
                url: "{{ route('event.calender-ajax') }}",
                type: 'POST',
                dataType: 'JSON',
                data: {
                    start: start.format(),
                    end: end.format()
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    var events = [];
                    res.records.forEach(element => {
                        events.push({
                            id: element.id,
                            title: element.subject != null ? element.subject : 'N/A',
                            start: new Date(element.start_date),
                            end: new Date(element.end_date),
                            className: 'bg-info'
                        });
                    });
                    callback(events);
                }
            });
        }
    });
</script>
@endsection