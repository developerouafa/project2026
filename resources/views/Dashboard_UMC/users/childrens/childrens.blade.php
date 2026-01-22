@extends('Dashboard_UMC.layouts.master')
@section('title')
    {{__('Dashboard/sections_trans.childrens')}}
@endsection
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
                <h4 class="content-children mb-0 my-auto">{{__('Dashboard/sections_trans.childrens')}}</h4>
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
        <div class="row">
            <div class="col-xl-12">
                <div class="card mg-b-20">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                                <a class="btn btn-danger" href="{{route('Children.deleteallChildrens')}}">{{__('Dashboard/messages.Deleteall')}}</a>

                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modaldemo8">
                                    {{__('Dashboard/sections_trans.addchildren')}}
                                </button>

                                <button type="button" class="btn btn-danger" id="btn_delete_all">{{trans('Dashboard/messages.Deletegroup')}}</button>
                        </div>
                    </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table key-buttons text-md-nowrap" data-page-length="50" style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                                <th> {{__('Dashboard/messages.Deletegroup')}} <input name="select_all"  id="example-select-all" type="checkbox"/></th>
                                            <th>{{__('Dashboard/sections_trans.children')}}</th>
                                            <th>{{__('Dashboard/sections_trans.status')}}</th>
                                            <th>{{__('Dashboard/sections_trans.section')}}</th>
                                            <th>{{__('Dashboard/sections_trans.usersection')}}</th>
                                            <th>{{__('Dashboard/sections_trans.userchildren')}}</th>
                                            <th>{{__('Dashboard/sections_trans.created_at')}}</th>
                                            <th>{{__('Dashboard/sections_trans.updated_at')}}</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($childrens as $x)
                                            @if ($x->section->status == 0)
                                                <tr>
                                                    <td>{{$x->id}}</td>
                                                        <td>
                                                            <input type="checkbox" name="delete_select" value="{{$x->id}}" class="delete_select">
                                                        </td>
                                                    <td><a href="{{route('Children.showchildren',$x->id)}}">{{$x->name}}</a> </td>
                                                    <td>
                                                        @if ($x->status == 0)
                                                            <a href="{{route('editstatusdéactivech', $x->id)}}"><i   class="text-warning ti-back-right"></i>{{__('Dashboard/sections_trans.disabled')}}</a>
                                                        @endif
                                                        @if ($x->status == 1)
                                                            <a href="{{route('editstatusactivech', $x->id)}}"><i   class="text-warning ti-back-right"></i>{{__('Dashboard/sections_trans.active')}}</a>
                                                        @endif
                                                    </td>
                                                    <td>{{$x->section->name}}</td>
                                                    <td>{{$x->section->user->name}}</td>
                                                    <td>{{$x->user->name}}</td>
                                                    <td> {{ $x->created_at->diffForHumans() }} </td>
                                                    <td> {{ $x->updated_at->diffForHumans() }} </td>
                                                    <td>
                                                            <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                            data-id="{{ $x->id }}" data-children="{{ $x->name }}"
                                                            data-section_id="{{ $x->parent_id }}" data-toggle="modal"
                                                            href="#exampleModal2" children="Update">
                                                            <i class="las la-pen"></i></a>
                                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                            data-id="{{ $x->id }}" data-children="{{ $x->name }}"
                                                            data-toggle="modal" href="#modaldemo9" children="Delete">
                                                            <i class="las la-trash"></i></a>
                                                    </td>
                                                </tr>
                                            @endif
                                                @include('Dashboard_UMC.users.childrens.delete_select')
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>
            </div>

            <!-- Create -->
                <div class="modal" id="modaldemo8">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-children">{{__('Dashboard/sections_trans.addchildren')}}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                            </div>
                                <div class="modal-body">
                                    <form action="{{route('Children.create')}}" method="post" enctype="multipart/form-data" autocomplete="off">
                                        @csrf
                                            <div class="form-group">
                                                <input placeholder="{{__('Dashboard/sections_trans.childrenen')}}" type="text" value="{{old('name_en')}}" class="form-control @error('name_en') is-invalid @enderror" id="name_en" name="name_en">
                                                <br>
                                                <input placeholder="{{__('Dashboard/sections_trans.childrenar')}}" type="text" value="{{old('name_ar')}}" class="form-control @error('name_ar') is-invalid @enderror" id="name_ar" name="name_ar">
                                                <br>
                                                <select name="section_id" value="{{old('section_id')}}" class="form-control select2" style="width: 100%" class="form-control @error('section_id') is-invalid @enderror">
                                                    <option value="" selected disabled>{{__('Dashboard/sections_trans.sections')}}</option>
                                                        @forelse ($sections as $section)
                                                            @if ($section->status == 1)
                                                                <option value="{{ $section->id }}"> {{ $section->name }} </option>
                                                            @endif
                                                            @empty
                                                            <tr>
                                                                <td colspan="5" class="text-center">{{__('Dashboard/sections_trans.nosectionyet')}}</td>
                                                            </tr>
                                                        @endforelse
                                                </select>
                                                <br>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn ripple btn-primary" type="submit">{{__('Dashboard/sections_trans.submit')}}</button>
                                                <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">{{__('Dashboard/messages.deletee')}}</button>
                                            </div>
                                    </form>
                                </div>
                        </div>
                    </div>
                </div>

            <!-- edit -->
                <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-children" id="exampleModalLabel">{{__('Dashboard/sections_trans.Updatechildren')}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('Children.update')}}" enctype="multipart/form-data" method="post" autocomplete="off">
                                    {{ method_field('patch') }}
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <input type="hidden" name="id" id="id">
                                        <input type="hidden" name="section_id" id="section_id">
                                        <input placeholder="{{__('Dashboard/sections_trans.children')}}" class="form-control" name="name_{{app()->getLocale()}}" id="children" type="text">
                                    </div>
                                    <div class="form-group">
                                        <select name="section_id" class="form-control" style="width: 100%" id="section_id">
                                            <option value="" selected disabled>{{__('Dashboard/sections_trans.sections')}}</option>
                                                @forelse ($sections as $section)
                                                    @if ($section->status == 0)
                                                        <option value="{{ $section->id }}"> {{ $section->name }} </option>
                                                    @endif
                                                    @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">{{__('Dashboard/sections_trans.nosectionyet')}}</td>
                                                    </tr>
                                                @endforelse
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">{{__('Dashboard/sections_trans.submit')}}</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Dashboard/sections_trans.Close')}}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- delete -->
                <div class="modal" id="modaldemo9">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-children">{{__('Dashboard/sections_trans.delete')}}</h6><button aria-label="Close" class="close" data-dismiss="modal"
                                    type="button"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <form action="{{route('Children.delete')}}" method="post">
                                {{ method_field('delete') }}
                                {{ csrf_field() }}
                                <div class="modal-body">
                                    <p>{{__('Dashboard/sections_trans.aresuredeleting')}}</p><br>
                                    <input type="hidden" name="id" id="id">
                                    <input type="hidden" value="1" name="page_id">
                                    <input class="form-control" name="children" id="children" type="text" readonly>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Dashboard/sections_trans.Close')}}</button>
                                    <button type="submit" class="btn btn-danger">{{__('Dashboard/sections_trans.delete')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

        </div>
    <!-- row closed -->

@endsection
@section('js')

    <script>
        $('#exampleModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var children = button.data('children')
            var category_id = button.data('category_id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #children').val(children);
            modal.find('.modal-body #category_id').val(category_id);
        })
    </script>

    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var children = button.data('children')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #children').val(children);
        })
    </script>

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

    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('/plugins/notify/js/notifit-custom.js')}}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!-- Internal form-elements js -->
    <script src="{{URL::asset('assets/js/form-elements.js')}}"></script>
@endsection
