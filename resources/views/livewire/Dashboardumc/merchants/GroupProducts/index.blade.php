
<div class="d-flex justify-content-between pb-1">
    <button class="btn btn-primary pull-right" wire:click="show_form_add" type="button">
        {{__('Dashboard/services.addsubservice')}}
    </button><br><br>
    <button class="btn btn-danger pull-left" wire:click="deleteall" type="button">
        {{__('Dashboard/messages.Deleteall')}}
    </button><br><br>
</div>
        <div class="table-responsive">
            <table id="example1" class="table key-buttons text-md-nowrap" data-page-length="50" style="text-align: center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th> Name Service </th>
                        <th> Total offer including tax </th>
                        <th> Description </th>
                        <th>Merchant</th>
                        <th> Created_at </th>
                        <th> Updated_at </th>
                        <th> Processes </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groups as $group)
                        <tr>
                            <td>{{ $loop->iteration}}</td>
                            <td>
                                {{ $group->name }}
                            </td>
                            <td>{{ number_format($group->Total_with_tax, 2) }}</td>
                            <td>{{ \Str::limit($group->notes, 50) }}</td>
                            <td>{{$group->merchant->name}}</td>
                            <td> {{ $group->created_at->diffForHumans() }} </td>
                            <td> {{ $group->updated_at->diffForHumans() }} </td>
                            <td>
                                <button wire:click="edit({{ $group->id }})" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>

                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteGroup{{$group->id}}"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @include('livewire.Dashboardumc.merchants.GroupProducts.delete')
                    @endforeach
            </table>
        </div>

