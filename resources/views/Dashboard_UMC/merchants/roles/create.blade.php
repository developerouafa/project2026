@extends('Dashboard_UMC.layouts.master')
@section('title')
    {{__('Dashboard/permissions.addusertype')}}
@endsection
@section('css')
    <!--Internal  Font Awesome -->
    <link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('page-header')
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">{{__('Dashboard/permissions.powers')}} </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                        {{__('Dashboard/permissions.addusertype')}} </span>
                </div>
            </div>
        </div>
@endsection

@section('content')

    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <button aria-label="Close" class="close" data-dismiss="alert" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{__('Dashboard/permissions.err')}}</strong>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('rolesmerchant.store') }}">
        @csrf
        <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card mg-b-20">
                        <div class="card-body">
                            <div class="main-content-label mg-b-5">
                                <div class="pull-right">
                                    <a class="btn btn-primary btn-sm" href="{{ route('rolesmerchant.index') }}">{{__('Dashboard/permissions.back')}}</a>
                                </div>
                            </div>
                            <div class="main-content-label mg-b-5">
                                <div class="col-xs-7 col-sm-7 col-md-7">
                                    <div class="form-group">
                                        <p>{{__('Dashboard/permissions.authorityname')}}</p>
                                        <input type="text" name="name" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <ul id="treeview1">
                                        <li>
                                            <a href="#">{{ __('Dashboard/permissions.powers') }}</a>
                                            <ul>
                                                @foreach ($permission as $value)
                                                    <li>
                                                        <label style="font-size: 16px;">
                                                            <input
                                                                type="checkbox"
                                                                name="permission[]"
                                                                value="{{ $value->id }}"
                                                                class="name"
                                                                {{ in_array($value->id, old('permission', [])) ? 'checked' : '' }}
                                                            >
                                                            {{ $value->name }}
                                                        </label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <button type="submit" class="btn btn-main-primary">{{__('Dashboard/permissions.save')}}</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        <!-- row closed -->
    </form>
@endsection
@section('js')
<!-- Internal Treeview js -->
<script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
@endsection
