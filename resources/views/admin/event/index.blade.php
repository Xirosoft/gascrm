@extends('layouts.admin')

@section('content')
    @if (isset($show))
        <event-details :data="{{ $data }}" :user="{{ Auth::user() }}" :permissions="{{ $permissions }}" :urls="{ 
            options : '{{ route('api-options') }}',
            event : '{{ route('event.index') }}',
            store : '{{ route('event.store') }}',
            update : '{{ route('event.update', $data->id) }}',
            destroy : '{{ route('event.destroy', $data->id) }}',
            note : '{{ route('note.store') }}',
            noteAll : '{{ route('note.all') }}',
            file : '{{ route('file.store') }}',
            fileAll : '{{ route('file.all') }}',
        }"></event-details>
    @else
        <div class="page-breadcrumb border-bottom">
            <div class="row">
                <div class="col-lg-3 col-md-2 col-12 align-self-center">
                    <h5 class="font-medium text-uppercase mb-0">
                        {{ __('lang.Events') }}
                    </h5>
                </div>
                <div class="col-lg-9 col-md-10 col-12 align-self-center">
                    
                    <form method="GET" action="{{ route('event.index') }}" class="search-form">
                        <div class="form-group mx-md-2 mb-2">
                            <input type="text" class="form-control input-outline-secondary" name="q" value="{{ Request::get('q') }}" placeholder="{{ __('lang.InputSearchText') }}">
                        </div>

                        <div class="btn-group mb-2">
                            <button type="submit" class="btn btn-secondary"><i class="fa fa-search"></i> {{ __('lang.Search') }}</button>
                            <a href="{{ route('event.index') }}" class="btn btn-secondary"><i class="fa fa-times"></i></a>
                            @can('add event') 
                            <a class="btn btn-secondary ml-2" href="javascript:void(0);" @click="$refs.childref.addModal('{{ route('event.store').qString() }}')"><i class="fa fa-plus"></i></a>
                            @endcan
                            
                            @can('edit event') 
                            <div class="btn-group ml-2">
                                <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown"data-display="static"></button>
                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-lg-right">
                                    @can('delete event') 
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="colCheckAction('Delete')">{{ __('lang.DeleteAll') }}</a>
                                    @endcan
                                </div>
                            </div>
                            @endcan
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="page-content container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped dataTable">
                            <thead>
                                <tr>
                                    <th class="chk-col"><input type="checkbox" id="col-checkbox-main" onclick="colCheckAll()"></th>
                                    <th>{{ __('lang.StartDatetime') }}</th>
                                    <th>{{ __('lang.EndDatetime') }}</th>
                                    <th>{{ __('lang.Subject') }}</th>
                                    <th>{{ __('lang.Name') }}</th>
                                    <th>{{ __('lang.RelatedTo') }}</th>
                                    <th>{{ __('lang.Assigned') }}</th>
                                    <th class="col-action"></th>
                                </tr>
                            </thead>

                            <tbody>
                            @if($records->count() > 0)
                                @foreach($records as $val)
                                <tr>
                                    <td><input type="checkbox" class="col-checkbox-all" value="{{ $val->id }}"></td>
                                    <td>{{ dateFormat($val->start_date, 1) }}</td>
                                    <td>{{ dateFormat($val->end_date, 1) }}</td>
                                    <td><a href="{{ route('event.show', $val->id) }}">{{ $val->subject }}</a></td>
                                    <td>{{ $val->conatctable != null ? $val->conatctable->name : '' }}</td>
                                    <td>{{ $val->account != null ? $val->account->name : '' }}</td>
                                    <td>{{ $val->user != null ? $val->user->name : '' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown"data-display="static"></button>
                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-lg-right"> 
                                                @can('details event') 
                                                <a class="dropdown-item" href="{{ route('event.show', $val->id) }}">{{ __('lang.Details') }}</a>
                                                @endcan                                               
                                                @can('edit event') 
                                                <a class="dropdown-item" href="javascript:void(0)" @click="$refs.childref.editModal({{ $val }}, '{{ route('event.update', $val->id) }}')">{{ __('lang.Edit') }}</a>
                                                @endcan
                                                
                                                @can('delete event') 
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="deleted('{{ route('event.destroy', $val->id).qString() }}')">{{ __('lang.Delete') }}</a>
                                                @endcan
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 pagi-msg">{!! pagiMsg($records) !!}</div>

                        <div class="col-sm-4 text-center">
                            {{ $records->appends(Request::except('page'))->links() }}
                        </div>

                        <div class="col-sm-4">
                            <div class="d-flex justify-content-center justify-content-sm-end">
                                <div class="input-group pagi-limit-box">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ __('lang.Show:') }} </span>
                                    </div>

                                    <select class="form-control pagi-limit" name="limit">
                                        @foreach(paginations() as $pag)
                                            <option value="{{ qUrl(['limit' => $pag]) }}" {{ ($pag == Request::get('limit')) ? 'selected' : '' }}>{{ $pag }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
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
    @endif
@endsection