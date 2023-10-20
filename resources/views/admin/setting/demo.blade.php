@extends('layouts.admin')

@section('content')
<div class="page-breadcrumb border-bottom">
    <div class="row">
        <div class="col-lg-3 col-md-4 col-6 align-self-center">
            <h5 class="font-medium text-uppercase mb-0">{{ __('lang.Industries') }}</h5>
        </div>
        <div class="col-lg-9 col-md-8 col-6 align-self-center">
            @if(isset($list))
                <a class="btn btn-info text-white float-right ml-3" href="{{ route('setting.industry.create').qString() }}"><i class="fa fa-plus"></i> {{ __('lang.AddNew') }}</a>
            @else
                <a class="btn btn-info text-white float-right ml-3" href="{{ route('setting.industry.index').qString() }}"><i class="fa fa-arrow-left"></i> Back to List</a>

                @if(isset($create) || isset($edit))
                <a class="btn btn-success text-white float-right ml-3 d-none d-md-block" href="javascript:document.getElementById('submit').click();">{{ __('lang.Save') }}</a>
                @endif
            @endif
        </div>
    </div>
</div>

<div class="page-content container-fluid">
    @if (isset($show)) 
    <div class="row justify-content-center">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('lang.Details') }}</h5>
                    <table class="table browser mt-4">
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td align="right">{{ $data->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('lang.Status') }}</td>
                                <td align="right">{{ $data->status ?? 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @elseif (isset($create) || isset($edit)) 
    <form method="POST" action="{{ isset($edit)?route('setting.industry.update', $data->id):route('setting.industry.store') }}{{ qString() }}" class="needs-validation" novalidate>
        @csrf

        @if (isset($edit))
            @method('PUT')
        @endif

        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>{{ __('lang.Name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', isset($data) ? $data->name : '') }}" required>

                            <span class="invalid-feedback">{{ __('lang.isRequired', ['field' => __('lang.Name')]) }}</span>
                            @if ($errors->has('name'))
                                <span class="invalid-feedback d-block">{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>{{ __('lang.Status') }} <span class="text-danger">*</span></label>
                            <select class="form-control" name="status" required>
                                @php ($status = old('status', isset($data) ? $data->status : ''))
                                @foreach(['Active', 'Deactivated'] as $sts)
                                    <option value="{{ $sts }}" {{ ($sts==$status)?'selected':''}}>{{ $sts }}</option>
                                @endforeach
                            </select>

                            <span class="invalid-feedback">{{ __('lang.isRequired', ['field' => __('lang.Status')]) }}</span>
                            @if ($errors->has('status'))
                                <span class="invalid-feedback d-block">{{ $errors->first('status') }}</span>
                            @endif
                        </div>                        
                    </div>

                    <div class="card-footer">
                        <button type="submit" id="submit" class="btn btn-success btn-rounded btn-block">{{ __('lang.Save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    
    @else
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('setting.industry.index') }}" class="search-form">
                        <div class="form-group mx-sm-2 mb-2">
                            <select class="form-control" name="status">
                                <option value="">{{ __('lang.AnyStatus') }}</option>
                                @foreach(['Active', 'Deactivated'] as $sts)
                                    <option value="{{ $sts }}" {{ (Request::get('status') == $sts) ? 'selected' : '' }}>{{ $sts }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mx-sm-2 mb-2">
                            <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="{{ __('lang.InputSearchText') }}">
                        </div>

                        <div class="btn-group mx-sm-2 mb-2">
                            <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> {{ __('lang.Search') }}</button>
                            <a href="{{ route('setting.industry.index') }}" class="btn btn-warning"><i class="fa fa-times"></i></a>
                        </div>
                    </form>
                    
                    <div class="table-responsive">
                        <table class="table table-striped dataTable">
                            <thead>
                                <tr>
                                    <th>{{ __('lang.Name') }}</th>
                                    <th>{{ __('lang.Status') }}</th>
                                    <th class="col-action"></th>
                                </tr>
                            </thead>

                            <tbody>
                            @if($users->count() > 0)
                                @foreach($users as $val)
                                <tr>
                                    <td>{{ $val->name }}</td>
                                    <td>{{ $val->status }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">Action</button>
                                            <div class="dropdown-menu dropdown-menu-sm">
                                                <a class="dropdown-item" href="{{ route('setting.industry.show', $val->id).qString() }}">{{ __('lang.Details') }}</a>
                                                <a class="dropdown-item" href="{{ route('setting.industry.edit', $val->id).qString() }}">{{ __('lang.Edit') }}</a>
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="deleted('{{ route('setting.industry.destroy', $val->id).qString() }}')">{{ __('lang.Delete') }}</a>
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
                        <div class="col-sm-4 pagi-msg">{!! pagiMsg($users) !!}</div>

                        <div class="col-sm-4 text-center">
                            {{ $users->appends(Request::except('page'))->links() }}
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
    </div>
    @endif
</div>
@endsection
