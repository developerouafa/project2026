@extends('Dashboard_UMC.layouts.master')
@section('css')


@endsection

@section('title')
    {{$section->name}} / {{trans('Dashboard/products.children_products')}}
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{$section->name}}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{trans('Dashboard/products.section_products')}}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row opened -->
    <div class="row row-sm">
        <!--div-->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        <div class="pull-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('Children_index') }}">{{__('Dashboard/permissions.back')}}</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped mg-b-0 text-md-nowrap table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('Dashboard/sections_trans.section')}}</th>
                                <th>{{trans('Dashboard/products.product')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{$section->name}}</td>
                                        <td>{{ $product->name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>{{__('Dashboard/messages.database')}}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div><!-- bd -->
                </div><!-- bd -->
            </div><!-- bd -->
        </div>
        <!--/div-->
    </div>
    <!-- /row -->
@endsection
@section('js')
@endsection
