@extends('Dashboard_UMC.layouts.master')
@section('title')
{{__('Dashboard/users.deletedusers')}}
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('Dashboard/users.deletedusers')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Dashboard/users.deletedusers')}}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- row opened -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    {{-- @can('Delete All Users softdelete') --}}
                        <a class="btn btn-danger" href="{{route('Users.deletealluserssoftdelete')}}">{{__('Dashboard/messages.Deleteall')}}</a>
                    {{-- @endcan --}}

                    {{-- @can('Delete Group Users softdelete') --}}
                        <button type="button" class="btn btn-danger" id="btn_delete_all">{{trans('Dashboard/messages.Deletegroup')}}</button>
                    {{-- @endcan --}}

                    {{-- @can('Restore All Users') --}}
                        <a class="btn btn-info" href="{{route('Users.restoreallusers')}}">{{__('Dashboard/messages.restoreall')}}</a>
                    {{-- @endcan --}}

                    {{-- @can('Restore Group Users') --}}
                        <button type="button" class="btn btn-info" id="btn_restore_all">{{__('Dashboard/messages.RestoreGroup')}}</button>
                    {{-- @endcan --}}
                </div>
            </div>
            {{-- @can('Show users softdelete') --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table key-buttons text-md-nowrap" data-page-length="50" style="text-align: center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    {{-- @can('Delete Group Users softdelete') --}}
                                        <th> {{__('Dashboard/messages.Deletegroup')}} <input name="select_all"  id="example-select-all" type="checkbox"/></th>
                                    {{-- @endcan --}}
                                    {{-- @can('Restore Group Users') --}}
                                        <th> {{__('Dashboard/messages.RestoreGroup')}} <input name="select_allrestore"  id="example-select-all" type="checkbox"/></th>
                                    {{-- @endcan --}}
                                    <th> {{__('Dashboard/users.name')}} </th>
                                    <th> {{__('Dashboard/users.phone')}} </th>
                                    <th> {{__('Dashboard/users.email')}} </th>
                                    <th> {{__('Dashboard/users.userstatus')}} </th>
                                    <th> {{__('Dashboard/users.usertype')}} </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        {{-- @can('Delete Group Users softdelete') --}}
                                            <td>
                                                <input type="checkbox" name="delete_select" value="{{$user->id}}" class="delete_select">
                                            </td>
                                        {{-- @endcan --}}
                                        {{-- @can('Restore Group Users') --}}
                                            <td>
                                                <input type="checkbox" name="restore" value="{{$user->id}}" class="delete_select">
                                            </td>
                                        {{-- @endcan --}}
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->can_login == 1)
                                                <span class="label text-success d-flex">
                                                    <div class="dot-label bg-success ml-1"></div>
                                                </span>
                                            @else
                                                <span class="label text-danger d-flex">
                                                    <div class="dot-label bg-danger ml-1"></div>
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (!empty($user->getRoleNames()))
                                                @foreach ($user->getRoleNames() as $v)
                                                    <label class="badge badge-success">{{ $v }}</label>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            {{-- @can('Restore One User') --}}
                                                <a href="{{route('Users.restoreusers', $user->id)}}">{{__('Dashboard/messages.restore')}}</a>
                                            {{-- @endcan --}}
                                            {{-- @can('Delete One User softdelete') --}}
                                                <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                    data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                                    data-toggle="modal" href="#modaldemo8" title="Delete">
                                                    <i class="las la-trash"></i>
                                                </a>
                                            {{-- @endcan --}}
                                        </td>
                                    </tr>
                                    {{-- @can('Delete Group Users softdelete') --}}
                                        @include('Dashboard_UMC.users.users.delete_selectsoftdelete')
                                    {{-- @endcan --}}

                                    {{-- @can('Restore Group Users') --}}
                                        @include('Dashboard_UMC.users.users.restoreall')
                                    {{-- @endcan --}}
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            {{-- @endcan --}}
        </div>
    </div>
    <!--/div-->

    <!-- Modal effects -->
    <div class="modal" id="modaldemo8">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">{{__('Dashboard/users.deletetheuser')}}</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('users.destroy', 'test') }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>{{__('Dashboard/users.aresureofthedeleting')}}</p><br>
                        <input type="hidden" value="3" name="page_id">
                        <input type="hidden" name="id" id="id" value="">
                        <input class="form-control" name="name" id="name" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Dashboard/users.cancel')}}</button>
                        <button type="submit" class="btn btn-danger">{{__('Dashboard/messages.deletee')}}</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>

</div>
<!-- /row -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')

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

    <script>
        $(function() {
            jQuery("[name=select_allrestore]").click(function(source) {
                checkboxes = jQuery("[name=restore]");
                for(var i in checkboxes){
                    checkboxes[i].checked = source.target.checked;
                }
            });
        })
    </script>

    <script type="text/javascript">
        $(function () {
            $("#btn_restore_all").click(function () {
                var selected = [];
                $("#example input[name=restore]:checked").each(function () {
                    selected.push(this.value);
                });

                if (selected.length > 0) {
                    $('#restore').modal('show')
                    $('input[id="restore_select_id"]').val(selected);
                }
            });
        });
    </script>

    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
    <!-- Internal Modal js-->
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>

    <script>
        $('#modaldemo8').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
        })

    </script>

@endsection
