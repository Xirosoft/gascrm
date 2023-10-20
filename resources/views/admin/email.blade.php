@extends('layouts.admin')

@section('content')
<div class="page-breadcrumb border-bottom">
    <div class="row">
        <div class="col-lg-3 col-md-2 col-12 align-self-center">
            <h5 class="font-medium text-uppercase mb-0">{{ __('lang.Emails') }}</h5>
        </div>
        <div class="col-lg-9 col-md-10 col-12 align-self-center">
            
            <form method="GET" action="{{ route('email.index') }}" class="search-form">
                <div class="form-group mx-md-2 mb-2">
                    <select class="form-control input-outline-secondary" name="type">
                        <option value="">{{ __('lang.AnyType') }}</option>
                        @foreach(['Lead', 'Account', 'Contact'] as $rl)
                            <option value="{{ $rl }}" {{ (Request::get('type') == $rl) ? 'selected' : '' }}>{{ $rl }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mx-md-2 mb-2">
                    <input type="text" class="form-control input-outline-secondary" name="q" value="{{ Request::get('q') }}" placeholder="{{ __('lang.InputSearchText') }}">
                </div>

                <div class="btn-group mb-2">
                    <button type="submit" class="btn btn-secondary"><i class="fa fa-search"></i> {{ __('lang.Search') }}</button>
                    <a href="{{ route('email.index') }}" class="btn btn-secondary"><i class="fa fa-times"></i></a>
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
                                    <th>{{ __('lang.Subject') }}</th>
                                    <th>{{ __('lang.From') }}</th>
                                    <th>{{ __('lang.To') }}</th>
                                    <th>{{ __('lang.Message') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                            @if($records->count() > 0)
                                @foreach($records as $val)
                                <tr>
                                    <td>{!! actionableColumn($val) !!}</td>
                                    <td><a href="javascript:void(0)" onclick="detailsModal({{ $val }})">{{ $val->subject }}</a></td>
                                    <td>{{ $val->from }}</td>
                                    <td>{{ $val->to }}</td>
                                    <td>{!! $val->message !!}</td>
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

<!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('lang.Details') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <table class="table browser no-border">
                    <tbody id="detailsBody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function detailsModal(detail) {
        var detailsBody = `<tr>
            <td class="no-border">{{ __('lang.Name') }}</td>
            <td class="no-border" align="right">`+ (detail.account ? detail.account.name : 'N/A') +`</td>
        </tr><tr>
            <td>{{ __('lang.Subject') }}</td>
            <td align="right">`+ detail.subject +`</td>
        </tr>
        <tr>
            <td>{{ __('lang.Message') }}</td>
            <td align="right">`+ detail.message +`</td>
        </tr>
        <tr>
            <td>{{ __('lang.From') }}</td>
            <td align="right">`+ detail.from +`</td>
        </tr>
        <tr>
            <td>{{ __('lang.To') }}</td>
            <td align="right">`+ detail.to +`</td>
        </tr>
        <tr>
            <td>{{ __('lang.CC') }}</td>
            <td align="right">`+ detail.cc +`</td>
        </tr>
        <tr>
            <td>{{ __('lang.BCC') }}</td>
            <td align="right">`+ detail.bcc +`</td>
        </tr>`;
        
        $('#detailsBody').html(detailsBody);
        $('#detailsModal').modal('show');
    }
</script>
@endsection
