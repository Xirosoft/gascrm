@extends('layouts.admin')

@section('content')
<div class="page-breadcrumb border-bottom">
    <div class="row">
        <div class="col-lg-3 col-md-2 col-12 align-self-center">
            <h5 class="font-medium text-uppercase mb-0">{{ __('lang.Users') }}</h5>
        </div>
        <div class="col-lg-9 col-md-10 col-12 align-self-center">
            
            <form method="GET" action="{{ route('user.index') }}" class="search-form">
                <div class="form-group mx-md-2 mb-2">
                    <select class="form-control input-outline-secondary" name="type">
                        <option value="">{{ __('lang.AnyType') }}</option>
                        @foreach(['Admin', 'Staff'] as $rl)
                            <option value="{{ $rl }}" {{ (Request::get('type') == $rl) ? 'selected' : '' }}>{{ $rl }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mx-md-2 mb-2">
                    <select class="form-control input-outline-secondary" name="status">
                        <option value="">{{ __('lang.AnyStatus') }}</option>
                        @foreach(['Active', 'Deactivated'] as $sts)
                            <option value="{{ $sts }}" {{ (Request::get('status') == $sts) ? 'selected' : '' }}>{{ $sts }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mx-md-2 mb-2">
                    <input type="text" class="form-control input-outline-secondary" name="q" value="{{ Request::get('q') }}" placeholder="{{ __('lang.InputSearchText') }}">
                </div>

                <div class="btn-group mb-2">
                    <button type="submit" class="btn btn-secondary"><i class="fa fa-search"></i> {{ __('lang.Search') }}</button>
                    <a href="{{ route('user.index') }}" class="btn btn-secondary"><i class="fa fa-times"></i></a>
                    @can('add user') 
                    <a class="btn btn-secondary ml-2" href="javascript:void(0);" onclick="addModal('{{ route('user.store').qString() }}')"><i class="fa fa-plus"></i></a>
                    @endcan
                    
                    @can('edit user') 
                    <div class="btn-group ml-2">
                        <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown"data-display="static"></button>
                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-lg-right">
                            <a class="dropdown-item" href="javascript:void(0)" onclick="colCheckAction('Active')">{{ __('lang.ActiveAll') }}</a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="colCheckAction('Deactivated')">{{ __('lang.DeactivateAll') }}</a>
                            @can('delete user') 
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
    <div class="row">
        <div class="col-12">
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
                                    <th>{{ __('lang.Type') }}</th>
                                    <th>{{ __('lang.EmailSignature') }}</th>
                                    <th>{{ __('lang.Status') }}</th>
                                    <th class="col-action"></th>
                                </tr>
                            </thead>

                            <tbody>
                            @if($records->count() > 0)
                                @foreach($records as $val)
                                <tr>
                                    <td><input type="checkbox" class="col-checkbox-all" value="{{ $val->id }}"></td>
                                    <td id="name_{{ $val->id }}">{{ $val->name }}</td>
                                    <td id="mobile_{{ $val->id }}">{{ $val->mobile }}</td>
                                    <td id="email_{{ $val->id }}">{{ $val->email }}</td>
                                    <td id="type_{{ $val->id }}">{{ $val->type }}</td>
                                    <td id="email_signature_{{ $val->id }}">{{ $val->email_signature }}</td>
                                    <td id="status_{{ $val->id }}">{{ $val->status }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown"data-display="static"></button>
                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-lg-right">
                                                @can('details user') 
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="detailsModal({{ $val }})">{{ __('lang.Details') }}</a>
                                                @endcan
                                                
                                                @can('edit user') 
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="editModal('{{ route('user.update', $val->id).qString() }}', {{ $val->id }})">{{ __('lang.Edit') }}</a>
                                                @endcan
                                                
                                                @can('delete user') 
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="deleted('{{ route('user.destroy', $val->id).qString() }}')">{{ __('lang.Delete') }}</a>
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
    </div>
</div>

<!-- Details Modal -->
@can('details user') 
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
@endcan

<!-- Store/Update Modal -->
@if(auth()->user()->can('add user') && auth()->user()->can('edit user'))
<div class="modal fade" id="crudModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('lang.AddNew') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <form method="POST" action="#" id="crudModalForm" class="needs-validation" novalidate>
                @csrf
                <input type="hidden" name="_method" id="_method" value="POST">
                <div class="modal-body">
                    <div id="crudModalMsg"></div>
                    <div class="form-group">
                        <label>{{ __('lang.Name') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" required>

                        <span class="invalid-feedback">{{ __('lang.isRequired', ['field' => __('lang.Name')]) }}</span>
                    </div>
                    

                    <div class="form-group">
                        <label>{{ __('lang.Mobile') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="mobile" id="mobile" required>

                        <span class="invalid-feedback">{{ __('lang.isRequired', ['field' => __('lang.Mobile')]) }}</span>
                    </div>
                    
                    <div class="form-group">
                        <label>{{ __('lang.Email') }} <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" id="email" required>

                        <span class="invalid-feedback">{{ __('lang.isRequired', ['field' => __('lang.Email')]) }}</span>
                    </div>

                    <div class="form-group">
                        <label>{{ __('lang.Password') }}</label>
                        <input type="password" class="form-control" name="password" id="password">

                        <span class="invalid-feedback">{{ __('lang.isRequired', ['field' => __('lang.Password')]) }}</span>
                    </div>

                    <div class="form-group">
                        <label>{{ __('lang.ConfirmPassword') }}</label>
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                    </div>
                    
                    <div class="form-group">
                        <label>{{ __('lang.Type') }} <span class="text-danger">*</span></label>
                        <select class="form-control" name="type" id="type" required>
                            <option value="">{{ __('lang.SelectType') }}</option>
                            @foreach(['Admin', 'Staff'] as $rl)
                                <option value="{{ $rl }}">{{ $rl }}</option>
                            @endforeach
                        </select>

                        <span class="invalid-feedback">{{ __('lang.isRequired', ['field' => __('lang.Type')]) }}</span>
                    </div>
                    
                    <div class="form-group">
                        <label>{{ __('lang.EmailSignature') }} <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="email_signature" id="email_signature" rows="6"></textarea>

                        <span class="invalid-feedback">{{ __('lang.isRequired', ['field' => __('lang.Email')]) }}</span>
                    </div>

                    <div class="form-group">
                        <label>{{ __('lang.Status') }}</label>
                        <select class="form-control" name="status" id="status" required>
                            <option value="">{{ __('lang.SelectStatus') }}</option>
                            @foreach(['Active', 'Deactivated'] as $st)
                                <option value="{{ $st }}">{{ $st }}</option>
                            @endforeach
                        </select>

                        <span class="invalid-feedback">{{ __('lang.isRequired', ['field' => __('lang.Status')]) }}</span>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary">{{ __('lang.Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
    function detailsModal(detail) {
        var detailsBody = `<tr>
            <td class="no-border">{{ __('lang.Name') }}</td>
            <td class="no-border" align="right">`+ detail.name +`</td>
        </tr>
        <tr>
            <td>{{ __('lang.Mobile') }}</td>
            <td align="right">`+ detail.mobile +`</td>
        </tr>
        <tr>
            <td>{{ __('lang.Email') }}</td>
            <td align="right">`+ detail.email +`</td>
        </tr>
        <tr>
            <td>{{ __('lang.Type') }}</td>
            <td align="right">`+ detail.type +`</td>
        </tr>
        <tr>
            <td>{{ __('lang.EmailSignature') }}</td>
            <td align="right">`+ detail.email_signature +`</td>
        </tr>
        <tr>
            <td>{{ __('lang.Status') }}</td>
            <td align="right">`+ detail.status +`</td>
        </tr>`;
        
        $('#detailsBody').html(detailsBody);
        $('#detailsModal').modal('show');
    }

    function addModal(url) {
        $('#name').val('');
        $('#mobile').val('');
        $('#email').val('');
        $('#type').val('');
        $('#email_signature').val('');
        $('#status').val('');
        
        $('#password').prop('required', true);
        $('#password_confirmation').prop('required', true);

        $('#_method').val('POST');
        $('#crudModalForm').attr('action', url);
        $('#crudModal').modal('show');
    }

    function editModal(url, id) {
        $('#name').val($('#name_'+id).html());
        $('#mobile').val($('#mobile_'+id).html());
        $('#email').val($('#email_'+id).html());
        $('#type').val($('#type_'+id).html());
        $('#email_signature').val($('#email_signature_'+id).html());
        $('#status').val($('#status_'+id).html());
        
        $('#password').prop('required', false);
        $('#password_confirmation').prop('required', false);

        $('#_method').val('PUT');
        $('#crudModalForm').attr('action', url);
        $('#crudModal').modal('show');
    }
</script>
@endsection
