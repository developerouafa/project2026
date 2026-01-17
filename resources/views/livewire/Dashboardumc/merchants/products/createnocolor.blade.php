@extends('Dashboard_UMC.layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>

    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
@endsection
@section('title')
    Products
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">
                    Products
                </h4>
                    <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Products</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->

@endsection
@section('content')
            <!-- row -->
                <div class="row row-sm">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                @livewire('Dashboardumc.merchants.products.createproductnocolor')
                            </div>
                        </div>
                    </div>
                </div>
            <!-- row closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')

@endsection
