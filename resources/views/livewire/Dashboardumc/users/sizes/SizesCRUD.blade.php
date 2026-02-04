<div>
    <button type="button" class="btn btn-main-primary"
     data-toggle="modal" data-target="#add_sizes" >
        + Add Sizes
    </button>

    @if (session()->has('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif

    <table class="table mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th width="150">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sizes as $size)
                <tr>
                    <td>{{ $size->id }}</td>
                    <td>{{ $size->name }}</td>
                    <td>{{ $size->description }}</td>
                    <td>
                        <button class="btn btn-sm btn-primary" wire:click="edit({{ $size->id }})">Edit</button>
                        <button class="btn btn-sm btn-danger" wire:click="delete({{ $size->id }})">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @include('livewire.Dashboardumc.users.sizes.modal')

</div>
