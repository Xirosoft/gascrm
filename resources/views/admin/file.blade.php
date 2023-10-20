@extends('layouts.admin')

@section('content')
<div class="page-breadcrumb border-bottom">
    <div class="row">
        <div class="col-lg-3 col-md-2 col-12 align-self-center">
            <h5 class="font-medium text-uppercase mb-0">{{ __('lang.Files') }}</h5>
        </div>
        <div class="col-lg-9 col-md-10 col-12 align-self-center">
            
            <form method="GET" action="{{ route('file.index') }}" class="search-form">
                <div class="form-group mx-md-2 mb-2">
                    <select class="form-control input-outline-secondary" name="type">
                        <option value="">{{ __('lang.AnyType') }}</option>
                        @foreach(['Lead', 'Account', 'Contact', 'Task', 'Event'] as $rl)
                            <option value="{{ $rl }}" {{ (Request::get('type') == $rl) ? 'selected' : '' }}>{{ $rl }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mx-md-2 mb-2">
                    <input type="text" class="form-control input-outline-secondary" name="q" value="{{ Request::get('q') }}" placeholder="{{ __('lang.InputSearchText') }}">
                </div>

                <div class="btn-group mb-2">
                    <button type="submit" class="btn btn-secondary"><i class="fa fa-search"></i> {{ __('lang.Search') }}</button>
                    <a href="{{ route('file.index') }}" class="btn btn-secondary"><i class="fa fa-times"></i></a>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="page-content container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">                    
                    <div class="table-responsive">
                        <table class="table table-striped dataTable">
                            <thead>
                                <tr>
                                    <th>{{ __('lang.Action') }}</th>
                                    <th>{{ __('lang.Name') }}</th>
                                    <th>{{ __('lang.Type') }}</th>
                                    <th>{{ __('lang.Size') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                            @if($records->count() > 0)
                                @foreach($records as $val)
                                <tr>
                                    <td>{!! actionableColumn($val) !!}</td>
                                    <td><a href="{{ $val->url }}" target="_blank">{{ $val->name }}</a></td>
                                    <td>{{ $val->mime_type }}</td>
                                    <td>{{ $val->size_text }}</td>
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
    </div>
</div>
@endsection
