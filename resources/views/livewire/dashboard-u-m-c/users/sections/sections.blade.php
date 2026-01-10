
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
                                {{-- <a class="btn btn-danger" href="{{route('Sections.deleteallSections')}}">{{__('Dashboard/messages.Deleteall')}}</a> --}}

                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add">
                                    {{__('Dashboard/sections_trans.add_sections')}}
                                </button>

                                <button type="button" class="btn btn-danger" id="btn_delete_all">{{trans('Dashboard/messages.Deletegroup')}}</button>

                            {{-- <form action="{{ route('Sections.export') }}">
                                <input type="submit" value="Export to excel" />
                            </form> --}}
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
                                                <td>
                                                    {{-- <a href="{{route('Sections.showsection',$section->id)}}">{{$section->name}}</a>  --}}
                                                    {{$section->name}}
                                                </td>
                                                <td>
                                                    @if ($section->status == 0)
                                                        {{-- <a href="{{route('editstatusdéactivesec', $section->id)}}"><i   class="text-warning ti-back-right"></i>{{__('Dashboard/sections_trans.disabled')}}</a> --}}
                                                    @endif
                                                    @if ($section->status == 1)
                                                        {{-- <a href="{{route('editstatusactivesec', $section->id)}}"><i   class="text-warning ti-back-right"></i>{{__('Dashboard/sections_trans.active')}}</a> --}}
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

                                            {{-- @include('Dashboard.dashboard_user.Sections.edit')

                                                @include('Dashboard.dashboard_user.Sections.delete')

                                                @include('Dashboard.dashboard_user.Sections.delete_select') --}}

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
