@extends('Dashboard_UMC.layouts.master')
@section('title')
    {{__('Dashboard/users.users')}}
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
                <h4 class="content-title mb-0 my-auto">{{__('Dashboard/users.users')}}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Dashboard/main-header_trans.viewall')}}</span>
            </div>
        </div>
    </div>
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
                        @can('Delete All Users')
                            <a class="btn btn-danger" href="{{route('Users.deleteallusers')}}">{{__('Dashboard/messages.Deleteall')}}</a>
                        @endcan

                        @can('Create User')
                            <a class="btn btn-primary" href="{{ route('users.create') }}">{{__('Dashboard/users.addauser')}}</a>
                        @endcan

                        @can('Delete Group Users')
                            <button type="button" class="btn btn-danger" id="btn_delete_all">{{trans('Dashboard/messages.Deletegroup')}}</button>
                        @endcan
                    </div>
                </div>
                @can('Show users')
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table key-buttons text-md-nowrap" data-page-length="50" style="text-align: center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        @can('Delete Group Users')
                                            <th> {{__('Dashboard/messages.DeleteGroup')}} <input name="select_all"  id="example-select-all" type="checkbox"/></th>
                                        @endcan
                                        <th> {{__('Dashboard/users.name')}} </th>
                                        <th> {{__('Dashboard/users.phone')}} </th>
                                        <th> {{__('Dashboard/users.email')}} </th>
                                        <th> {{__('Dashboard/users.userstatus')}} </th>
                                        <th> {{__('Dashboard/users.usertype')}} </th>
                                        <th> {{__('Dashboard/users.userolestaus')}} </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            @can('Delete Group Users')
                                                <td>
                                                    <input type="checkbox" name="delete_select" value="{{$user->id}}" class="delete_select">
                                                </td>
                                            @endcan
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
                                                @if ($user->account_state == 'active')
                                                    <span class="label text-success">
                                                       Active
                                                    </span>
                                                @elseif ($user->account_state == 'closed')
                                                    <span class="label text-danger">
                                                        Closed
                                                    </span>
                                                @elseif ($user->account_state == 'pending')
                                                    <span class="label text-warning">
                                                        Pending
                                                    </span>
                                                @elseif ($user->account_state == 'suspended')
                                                    <span class="label text-danger">
                                                        Suspended
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
                                                @can('Edit User')
                                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-info"
                                                    title="تعديل"><i class="las la-pen"></i></a>
                                                @endcan

                                                @can('Delete User')
                                                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                    data-user_id="{{ $user->id }}" data-username="{{ $user->name }}"
                                                    data-toggle="modal" href="#modaldemo8" title="حذف"><i
                                                        class="las la-trash"></i></a>
                                                @endcan
                                            </td>
                                        </tr>
                                        @can('Delete Group Users')
                                            @include('Dashboard_UMC.users.users.delete_select')
                                        @endcan
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endcan
            </div>
        </div>
        <!--/div-->

        <!-- Modal effects -->
        <div class="modal" id="modaldemo8">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">{{__('Dashboard/users.deletetheuser')}} </h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('users.destroy', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>{{__('Dashboard/users.aresureofthedeleting')}}</p><br>
                            <input type="hidden" value="1" name="page_id">
                            <input type="hidden" name="user_id" id="user_id" value="">
                            <input class="form-control" name="username" id="username" type="text" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Dashboard/users.cancel')}}</button>
                            <button type="submit" class="btn btn-danger">{{__('Dashboard/messages.deletee')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')

    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
    <!-- Internal Modal js-->
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>

     {{-- Start Selected Group  --}}
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
    {{-- End Selected Group --}}

    {{-- delete user --}}
    <script>
        $('#modaldemo8').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var user_id = button.data('user_id')
            var username = button.data('username')
            var modal = $(this)
            modal.find('.modal-body #user_id').val(user_id);
            modal.find('.modal-body #username').val(username);
        })
    </script>


    <!-- Internal Data tables -->
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>
@endsection
