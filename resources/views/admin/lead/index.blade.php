@extends('layouts.admin')

@section('content')
    @if (isset($show))
        <lead-details :data="{{ $data }}" :user="{{ Auth::user() }}" :permissions="{{ $permissions }}" :urls="{ 
            options : '{{ route('api-options') }}',
            lead : '{{ route('lead.index') }}',
            printable : '{{ route('lead.printable', $data->id) }}',
            store : '{{ route('lead.store') }}',
            update : '{{ route('lead.update', $data->id) }}',
            destroy : '{{ route('lead.destroy', $data->id) }}',
            follow : '{{ route('lead.follow', $data->id) }}',
            owner : '{{ route('lead.owner-change', $data->id) }}',
            convert : '{{ route('lead.convert', $data->id) }}',
            statusChange : '{{ route('lead.status-change') }}',
            task : '{{ route('task.store') }}',
            email : '{{ route('email.store') }}',
            event : '{{ route('event.store') }}',
            note : '{{ route('note.store') }}',
            noteAll : '{{ route('note.all') }}',
            file : '{{ route('file.store') }}',
            fileAll : '{{ route('file.all') }}',
        }"></lead-details>
    @else
        <div class="page-breadcrumb border-bottom">
            <div class="row">
                <div class="col-lg-3 col-md-2 col-12 align-self-center">
                    <h5 class="font-medium text-uppercase mb-0">{{ __('lang.Leads') }}</h5>
                </div>
                <div class="col-lg-9 col-md-10 col-12 align-self-center">
                    
                    <form method="GET" action="{{ route('lead.index') }}" class="search-form">
                        <div class="form-group mx-md-2 mb-2">
                            <select class="form-control input-outline-secondary" name="status">
                                <option value="">{{ __('lang.AnyStatus') }}</option>
                                @foreach($leadStatus as $sts)
                                    <option value="{{ $sts->id }}" {{ (Request::get('status') == $sts->id) ? 'selected' : '' }}>{{ $sts->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mx-md-2 mb-2">
                            <input type="text" class="form-control input-outline-secondary" name="q" value="{{ Request::get('q') }}" placeholder="{{ __('lang.InputSearchText') }}">
                        </div>

                        <div class="btn-group mb-2">
                            <button type="submit" class="btn btn-secondary"><i class="fa fa-search"></i> {{ __('lang.Search') }}</button>
                            <a href="{{ route('lead.index') }}" class="btn btn-secondary"><i class="fa fa-times"></i></a>
                            @can('add lead') 
                            <a class="btn btn-secondary ml-2" href="javascript:void(0);" @click="$refs.childref.addModal('{{ route('lead.store').qString() }}')"><i class="fa fa-plus"></i></a>
                            @endcan
                            
                            @can('edit lead') 
                            <div class="btn-group ml-2">
                                <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown"data-display="static"></button>
                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-lg-right">
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="colCheckAction('Active')">{{ __('lang.ActiveAll') }}</a>
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="colCheckAction('Deactivated')">{{ __('lang.DeactivateAll') }}</a>
                                    @can('delete lead') 
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
                                    <th>{{ __('lang.Name') }}</th>
                                    <th>{{ __('lang.Title') }}</th>
                                    <th>{{ __('lang.Company') }}</th>
                                    <th>{{ __('lang.Mobile') }}</th>
                                    <th>{{ __('lang.Email') }}</th>
                                    <th>{{ __('lang.LeadStatus') }}</th>
                                    <th>{{ __('lang.LeadOwner') }}</th>
                                    <th class="col-action"></th>
                                </tr>
                            </thead>

                            <tbody>
                            @if($records->count() > 0)
                                @foreach($records as $val)
                                <tr>
                                    <td><input type="checkbox" class="col-checkbox-all" value="{{ $val->id }}"></td>
                                    <td><a href="{{ route('lead.show', $val->id) }}">{{ $val->name }}</a></td>
                                    <td>{{ $val->title }}</td>
                                    <td>{{ $val->company }}</td>
                                    <td>{{ $val->mobile }}</td>
                                    <td>{{ $val->email }}</td>
                                    <td>{{ $val->lead_status != null ? $val->lead_status->name : '-' }}</td>
                                    <td>{{ $val->owner != null ? $val->owner->name : '-' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown"data-display="static"></button>
                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-lg-right">
                                                @can('details lead') 
                                                <a class="dropdown-item" href="{{ route('lead.show', $val->id) }}">{{ __('lang.Details') }}</a>
                                                @endcan
                                                
                                                @can('edit lead') 
                                                <a class="dropdown-item" href="javascript:void(0)" @click="$refs.childref.editModal({{ $val }}, '{{ route('lead.update', $val->id) }}')">{{ __('lang.Edit') }}</a>
                                                @endcan
                                                
                                                @can('delete lead') 
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="deleted('{{ route('lead.destroy', $val->id).qString() }}')">{{ __('lang.Delete') }}</a>
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
        @if(auth()->user()->can('add lead') || auth()->user()->can('edit lead'))
        <lead-form ref="childref" page="{{ Request::routeIs('lead.create') ? 'create' : 'index' }}" :user="{{ Auth::user() }}" :urls="{ 
            options : '{{ route('api-options') }}', 
            lead : '{{ route('lead.index') }}', 
            store : '{{ route('lead.store') }}'
        }"></lead-form>
        @endif
    @endif
@endsection