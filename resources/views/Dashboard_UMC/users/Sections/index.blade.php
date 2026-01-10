@extends('Dashboard_UMC.layouts.master')
@section('title')
    {{__('Dashboard/main-sidebar_trans.sections')}}
@stop
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('Dashboard/main-sidebar_trans.sections')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Dashboard/main-sidebar_trans.view_all')}}</span>
            </div>
        </div>
    </div>
@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- row -->
        <!-- row opened -->
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                                <a class="btn btn-danger" href="{{route('Sections.deleteallSections')}}">{{__('Dashboard/messages.Deleteall')}}</a>

                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add">
                                    {{__('Dashboard/sections_trans.add_sections')}}
                                </button>

                                <button type="button" class="btn btn-danger" id="btn_delete_all">{{trans('Dashboard/messages.Deletegroup')}}</button>

                            <form action="{{ route('Sections.export') }}">
                                <input type="submit" value="Export to excel" />
                            </form>
                        </div>
                    </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table key-buttons text-md-nowrap" data-page-length="50" style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                                <th> {{__('Dashboard/messages.DeleteGroup')}} <input name="select_all"  id="example-select-all" type="checkbox"/></th>
                                            <th>{{__('Dashboard/sections_trans.name_sections')}}</th>
                                            <th>{{__('Dashboard/sections_trans.status')}}</th>
                                            <th>{{__('Dashboard/users.createdbyuser')}}</th>
                                            <th>{{__('Dashboard/sections_trans.created_at')}}</th>
                                            <th>{{__('Dashboard/sections_trans.updated_at')}}</th>
                                            <th>{{__('Dashboard/sections_trans.Processes')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sections as $section)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                    <td>
                                                        <input type="checkbox" name="delete_select" value="{{$section->id}}" class="delete_select">
                                                    </td>
                                                <td><a href="{{route('Sections.showsection',$section->id)}}">{{$section->name}}</a> </td>
                                                <td>
                                                    @if ($section->status == 0)
                                                        <a href="{{route('editstatusdéactivesec', $section->id)}}"><i   class="text-warning ti-back-right"></i>{{__('Dashboard/sections_trans.disabled')}}</a>
                                                    @endif
                                                    @if ($section->status == 1)
                                                        <a href="{{route('editstatusactivesec', $section->id)}}"><i   class="text-warning ti-back-right"></i>{{__('Dashboard/sections_trans.active')}}</a>
                                                    @endif
                                                </td>
                                                <td> <a href="#">{{$section->user->name}}</a> </td>
                                                <td> {{ $section->created_at->diffForHumans() }} </td>
                                                <td> {{ $section->updated_at->diffForHumans() }} </td>
                                                <td>
                                                    <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"  data-toggle="modal" href="#edit{{$section->id}}"><i class="las la-pen"></i></a>

                                                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale" data-toggle="modal" href="#delete{{$section->id}}"><i class="las la-trash"></i></a>
                                                </td>
                                            </tr>

                                           @include('Dashboard_UMC.users.Sections.edit')

                                               @include('Dashboard_UMC.users.Sections.delete')

                                               @include('Dashboard_UMC.users.Sections.delete_select')

                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>
            </div>
            <!--/div-->
        </div>
        <!-- row closed -->

        @include('Dashboard_UMC.users.Sections.add')

@endsection
@section('js')

    {{-- Start script Delete Select Group Section --}}
        <script>
            $(function() {
                jQuery("[name=select_all]").click(function(source) {
                    checkboxes = jQuery("[name=delete_select]");
                    for(var i in checkboxes){
                        checkboxes[i].checked = source.target.checked;
                    }
                });
            })
        </script>

        <script type="text/javascript">
            $(function () {
                $("#btn_delete_all").click(function () {
                    var selected = [];
                    $("#example input[name=delete_select]:checked").each(function () {
                        selected.push(this.value);
                    });

                    if (selected.length > 0) {
                        $('#delete_select').modal('show')
                        $('input[id="delete_select_id"]').val(selected);
                    }
                });
            });
        </script>
    {{-- End script Delete Select Group Section --}}

    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('/plugins/notify/js/notifit-custom.js')}}"></script>

@endsection
