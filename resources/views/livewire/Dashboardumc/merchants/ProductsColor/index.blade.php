
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
                        {{-- <th>Photo</th> --}}
                        <th>Name</th>
                        {{-- <th>Section</th>
                        <th>Child</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Status</th> --}}
                        <th> Created_at </th>
                        <th> Updated_at </th>
                        <th> Processes </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $loop->iteration}}</td>
                            <td>
                                {{ $product->name }}
                            </td>

                            <td> {{ $product->created_at->diffForHumans() }} </td>
                            <td> {{ $product->updated_at->diffForHumans() }} </td>
                            <td>
                                <button wire:click="edit({{ $product->id }})" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>

                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteproduct{{$product->id}}"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @include('livewire.Dashboardumc.merchants.ProductsColor.delete')
                    @endforeach
            </table>
        </div>

