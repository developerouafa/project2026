@extends('Dashboard_UMC.layouts.master')
@section('css')
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Sections</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ View All</span>
            </div>
        </div>
    </div>
@endsection
@section('content')
	<livewire:dashboard-u-m-c.users.sections.sections/>
@endsection
@section('js')
@endsection
