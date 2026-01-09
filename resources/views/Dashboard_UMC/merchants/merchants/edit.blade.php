@extends('Dashboard_UMC.layouts.master')
@section('title')
    {{__('Dashboard/merchants.modifyamerchant')}}
@endsection
@section('css')
    <!-- Internal Nice-select css  -->
    <link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('Dashboard/merchants.merchants')}}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/{{__('Dashboard/merchants.modifyamerchant')}}</span>
            </div>
        </div>
    </div>
@endsection
@section('content')

    <!-- row -->
        <div class="row">
            <div class="col-lg-12 col-md-12">

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>{{__('Dashboard/merchants.err')}}</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-right">
                                <a class="btn btn-primary btn-sm" href="{{ route('merchant.index') }}">{{__('Dashboard/merchants.back')}}</a>
                            </div>
                        </div><br>

                        <form action="{{ route('merchant.update', $merchant->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="">
                                <div class="row mg-b-20">
                                    <div class="parsley-input col-md-6" id="fnWrapper">
                                        <label>{{__('Dashboard/merchants.name')}}  <span class="tx-danger">*</span></label>
                                        <input value="{{$merchant->name}}" class="form-control" required name="name" type="text" autocomplete="name_{{app()->getLocale()}}" >
                                    </div>
                                    <div class="parsley-input col-md-6" id="fnWrapper">
                                        <label>{{__('Dashboard/merchants.phone')}}  <span class="tx-danger">*</span></label>
                                        <input value="{{$merchant->phone}}" class="form-control" required name="phone" type="text" autocomplete="phone" >
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <div class="row mg-b-20">
                                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                        <label>{{__('Dashboard/merchants.email')}} <span class="tx-danger">*</span></label>
                                        <input type="email" name="email" class="form-control" required value="{{ old('email', $merchant->email) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{__('Dashboard/merchants.merchantrolestaus')}}</label>
                                        <select name="account_state" id="select-beast" class="form-control  nice-select  custom-select">
                                            <option value="{{ $merchant->account_state}}">
                                                @if ($merchant->account_state == 'active')
                                                    <p> Is Active</p>
                                                @elseif ($merchant->account_state == 'closed')
                                                    <p> Is Closed</p>
                                                @elseif ($merchant->account_state == 'pending')
                                                    <p> Is Pending</p>
                                                @elseif ($merchant->account_state == 'suspended')
                                                    <p> Is Suspended</p>
                                                @endif
                                            </option>
                                            <option value="active">Active</option>
                                            <option value="closed">Closed</option>
                                            <option value="pending">Pending</option>
                                            <option value="suspended">Suspended</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mg-b-20">
                                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                    <label>{{__('Dashboard/merchants.password')}} <span class="tx-danger">*</span></label>
                                    <input type="password" name="password" class="form-control">
                                </div>

                                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                    <label>{{__('Dashboard/merchants.currentpassword')}} <span class="tx-danger">*</span></label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                            </div>

                            <div class="row mg-b-20">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>{{__('Dashboard/merchants.merchanttype')}}</strong>
                                        <select name="roles[]" class="form-control" multiple>
                                            @foreach($roles as $id => $roleName)
                                                <option value="{{ $id }}"
                                                    {{ in_array($id, old('roles', $merchantRole ?? [])) ? 'selected' : '' }}>
                                                    {{ $roleName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mg-t-30">
                                <button class="btn btn-main-primary pd-x-20" type="submit">{{__('Dashboard/merchants.update')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Nice-select js-->
    <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>

    <!--Internal  Parsley.min js -->
    <script src="{{URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <!-- Internal Form-validation js -->
    <script src="{{URL::asset('assets/js/form-validation.js')}}"></script>
@endsection
