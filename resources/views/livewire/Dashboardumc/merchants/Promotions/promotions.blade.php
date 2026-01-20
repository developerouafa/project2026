<div>
    <div class="flex justify-between mb-4">
        <button type="button" class="btn btn-main-primary" data-toggle="modal" data-target="#Add">+ Add promotion</button>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card-body">
        <div class="table-responsive">
            <table id="example1" class="table key-buttons text-md-nowrap">
                <thead class="bg-gray-100">
                    <tr>
                        <th>#</th>
                        <th>Price</th>
                        <th>Product</th>
                        <th>Merchant</th>
                        <th>Start_Time</th>
                        <th>End_Time</th>
                        <th>created_at</th>
                        <th>updated_at</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($promotions as $promotion)
                        <tr class="border-b">
                            <td>{{ $loop->iteration}}</td>
                            <td>{{ $promotion->price}}</td>
                            <td>
                                {{ $promotion->Product?->name ?? '—' }}
                            </td>
                            <td>
                                {{ $promotion->Merchant?->name ?? '_' }}
                            </td>
                            <td>{{ $promotion->start_time }}</td>
                            <td>{{ $promotion->end_time }}</td>
                            <td>{{ $promotion->created_at->diffForHumans() }}</td>
                            <td>{{ $promotion->updated_at->diffForHumans() }}</td>
                            <td class="flex gap-2">
                                <button type="button" class="btn btn-sm btn-primary"
                                        data-toggle="modal" data-target="#edit{{$promotion->id}}">
                                        Edit
                                    </button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{$promotion->id}}"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        @include('livewire.Dashboardumc.merchants.Promotions.delete')
                        @include('livewire.Dashboardumc.merchants.Promotions.EditModal')
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('livewire.Dashboardumc.merchants.Promotions.Modal')
</div>
