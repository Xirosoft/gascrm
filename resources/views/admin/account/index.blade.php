@extends('layouts.admin')

@section('content')
    @if (isset($show))
        <account-details :data="{{ $data }}" :user="{{ Auth::user() }}" :permissions="{{ $permissions }}" :urls="{ 
            options : '{{ route('api-options') }}',
            account : '{{ route('account.index') }}',
            printable : '{{ route('account.printable', $data->id) }}',
            store : '{{ route('account.store') }}',
            update : '{{ route('account.update', $data->id) }}',
            destroy : '{{ route('account.destroy', $data->id) }}',
            follow : '{{ route('account.follow', $data->id) }}',
            owner : '{{ route('account.owner-change', $data->id) }}',
            task : '{{ route('task.store') }}',
            email : '{{ route('email.store') }}',
            event : '{{ route('event.store') }}',
            note : '{{ route('note.store') }}',
            noteAll : '{{ route('note.all') }}',
            file : '{{ route('file.store') }}',
            fileAll : '{{ route('file.all') }}',
        }"></account-details>
    @else
        <div class="page-breadcrumb border-bottom">
            <div class="row">
                <div class="col-lg-3 col-md-2 col-12 align-self-center">
                    <h5 class="font-medium text-uppercase mb-0">{{ __('lang.Accounts') }}</h5>
                </div>
                <div class="col-lg-9 col-md-10 col-12 align-self-center">
                    
                    <form method="GET" action="{{ route('account.index') }}" class="search-form">
                        <div class="form-group mx-md-2 mb-2">
                            <select class="form-control input-outline-secondary" name="status">
                                <option value="">{{ __('lang.AnyType') }}</option>
                                @foreach($accountTypes as $typ)
                                    <option value="{{ $typ->id }}" {{ (Request::get('status') == $typ->id) ? 'selected' : '' }}>{{ $typ->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mx-md-2 mb-2">
                            <input type="text" class="form-control input-outline-secondary" name="q" value="{{ Request::get('q') }}" placeholder="{{ __('lang.InputSearchText') }}">
                        </div>

                        <div class="btn-group mb-2">
                            <button type="submit" class="btn btn-secondary"><i class="fa fa-search"></i> {{ __('lang.Search') }}</button>
                            <a href="{{ route('account.index') }}" class="btn btn-secondary"><i class="fa fa-times"></i></a>
                            @can('add account') 
                            <a class="btn btn-secondary ml-2" href="javascript:void(0);" @click="$refs.childref.addModal('{{ route('account.store').qString() }}')"><i class="fa fa-plus"></i></a>
                            @endcan
                            
                            @can('edit account') 
                            <div class="btn-group ml-2">
                                <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown"data-display="static"></button>
                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-lg-right">
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="colCheckAction('Active')">{{ __('lang.ActiveAll') }}</a>
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="colCheckAction('Deactivated')">{{ __('lang.DeactivateAll') }}</a>
                                    @can('delete account') 
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
                                    <th>{{ __('lang.Mobile') }}</th>
                                    <th>{{ __('lang.Email') }}</th>
                                    <th>{{ __('lang.Fax') }}</th>
                                    <th>{{ __('lang.Website') }}</th>
                                    <th>{{ __('lang.AccountOwner') }}</th>
                                    <th class="col-action"></th>
                                </tr>
                            </thead>

                            <tbody>
                            @if($records->count() > 0)
                                @foreach($records as $val)
                                <tr>
                                    <td><input type="checkbox" class="col-checkbox-all" value="{{ $val->id }}"></td>
                                    <td><a href="{{ route('account.show', $val->id) }}">{{ $val->name }}</a></td>
                                    <td>{{ $val->mobile }}</td>
                                    <td>{{ $val->email }}</td>
                                    <td>{{ $val->fax }}</td>
                                    <td>{{ $val->website }}</td>
                                    <td>{{ $val->owner != null ? $val->owner->name : '-' }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown"data-display="static"></button>
                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-lg-right">
                                                @can('details account') 
                                                <a class="dropdown-item" href="{{ route('account.show', $val->id) }}">{{ __('lang.Details') }}</a>
                                                @endcan
                                                
                                                @can('edit account') 
                                                <a class="dropdown-item" href="javascript:void(0)" @click="$refs.childref.editModal({{ $val }}, '{{ route('account.update', $val->id) }}')">{{ __('lang.Edit') }}</a>
                                                @endcan
                                                
                                                @can('delete account') 
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="deleted('{{ route('account.destroy', $val->id).qString() }}')">{{ __('lang.Delete') }}</a>
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

        <!-- Update Modal -->
        @if(auth()->user()->can('add account') || auth()->user()->can('edit account'))
        <account-form ref="childref" page="{{ Request::routeIs('account.create') ? 'create' : 'index' }}" :user="{{ Auth::user() }}" :urls="{ 
            options : '{{ route('api-options') }}', 
            account : '{{ route('account.index') }}', 
            store : '{{ route('account.store') }}'
        }"></account-form>
        @endif
    @endif
@endsection
