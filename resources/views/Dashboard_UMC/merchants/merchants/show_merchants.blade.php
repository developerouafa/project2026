@extends('Dashboard_UMC.layouts.master')
@section('title')
    {{__('Dashboard/merchants.merchants')}}
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
                <h4 class="content-title mb-0 my-auto">{{__('Dashboard/merchants.merchants')}}</h4>
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
                        @can('Delete All merchants')
                            <a class="btn btn-danger" href="{{route('merchant.deleteallmerchants')}}">{{__('Dashboard/messages.Deleteall')}}</a>
                        @endcan

                        @can('Create merchant')
                            <a class="btn btn-primary" href="{{ route('merchant.create') }}">{{__('Dashboard/merchants.addamerchant')}}</a>
                        @endcan

                        @can('Delete Group merchants')
                            <button type="button" class="btn btn-danger" id="btn_delete_all">{{trans('Dashboard/messages.Deletegroup')}}</button>
                        @endcan
                    </div>
                </div>
                @can('Show merchants')
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table key-buttons text-md-nowrap" data-page-length="50" style="text-align: center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        @can('Delete Group merchants')
                                            <th> {{__('Dashboard/messages.DeleteGroup')}} <input name="select_all"  id="example-select-all" type="checkbox"/></th>
                                        @endcan
                                        <th> {{__('Dashboard/merchants.name')}} </th>
                                        <th> {{__('Dashboard/merchants.phone')}} </th>
                                        <th> {{__('Dashboard/merchants.email')}} </th>
                                        <th> {{__('Dashboard/merchants.merchantstatus')}} </th>
                                        <th> {{__('Dashboard/merchants.merchanttype')}} </th>
                                        <th> {{__('Dashboard/merchants.merchantrolestaus')}} </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($merchants as $merchant)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            @can('Delete Group merchants')
                                                <td>
                                                    <input type="checkbox" name="delete_select" value="{{$merchant->id}}" class="delete_select">
                                                </td>
                                            @endcan
                                            <td>{{ $merchant->name }}</td>
                                            <td>{{ $merchant->phone }}</td>
                                            <td>{{ $merchant->email }}</td>
                                            <td>
                                                @if ($merchant->can_login == 1)
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
                                                @if ($merchant->account_state == 'active')
                                                    <span class="label text-success">
                                                       Active
                                                    </span>
                                                @elseif ($merchant->account_state == 'closed')
                                                    <span class="label text-danger">
                                                        <i class="text-warning ti-back-right"></i>
                                                        <div class="dot-label bg-danger ml-1 mr-1"></div>
                                                    </span>
                                                @elseif ($merchant->account_state == 'pending')
                                                    <span class="label text-warning">
                                                        <i class="text-warning ti-back-right"></i>
                                                        <div class="dot-label bg-warning ml-1 mr-1"></div>
                                                    </span>
                                                @elseif ($merchant->account_state == 'suspended')
                                                    <span class="label text-danger">
                                                        <i class="text-warning ti-back-right"></i>
                                                        <div class="dot-label bg-danger ml-1 mr-1"></div>
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (!empty($merchant->getRoleNames()))
                                                    @foreach ($merchant->getRoleNames() as $v)
                                                        <label class="badge badge-success">{{ $v }}</label>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                @can('Edit merchant')
                                                    <a href="{{ route('merchant.edit', $merchant->id) }}" class="btn btn-sm btn-info"
                                                    title="تعديل"><i class="las la-pen"></i></a>
                                                @endcan

                                                @can('Delete merchant')
                                                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                    data-merchant_id="{{ $merchant->id }}" data-merchantname="{{ $merchant->name }}"
                                                    data-toggle="modal" href="#modaldemo8" title="حذف"><i
                                                        class="las la-trash"></i></a>
                                                @endcan
                                            </td>
                                        </tr>
                                        @can('Delete Group merchant')
                                            @include('Dashboard_UMC.merchants.merchants.delete_select')
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
                        <h6 class="modal-title">{{__('Dashboard/merchants.deletethemerchant')}} </h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('merchant.destroy', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>{{__('Dashboard/merchants.aresureofthedeleting')}}</p><br>
                            <input type="hidden" value="1" name="page_id">
                            <input type="hidden" name="merchant_id" id="merchant_id" value="">
                            <input class="form-control" name="merchantname" id="merchantname" type="text" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Dashboard/merchants.cancel')}}</button>
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

    {{-- delete merchant --}}
    <script>
        $('#modaldemo8').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var merchant_id = button.data('merchant_id')
            var merchantname = button.data('merchantname')
            var modal = $(this)
            modal.find('.modal-body #merchant_id').val(merchant_id);
            modal.find('.modal-body #merchantname').val(merchantname);
        })
    </script>

@endsection
