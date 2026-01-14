{{-- <div wire:ignore.self class="modal fade show d-block" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5>{{ $size_id ? 'Edit Size' : 'Add Size' }}</h5>
                <button type="button" wire:click="closeModal" class="btn-close"></button>
            </div>

            <div class="modal-body">
                <input type="text" wire:model="name" class="form-control" placeholder="Size name">
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror

                <textarea wire:model="description" class="form-control mt-2" placeholder="Description"></textarea>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" wire:click="closeModal">Cancel</button>
                <button class="btn btn-primary" wire:click="store">Save</button>
            </div>

        </div>
    </div>
</div>
    <div class="modal-backdrop fade show"></div> --}}
<!-- Modal -->
<div wire:ignore.self class="modal fade" tabindex="-1" id="add_sizes" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <form wire:submit.prevent="store" autocomplete="off">
                @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Add </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" wire:model="name" class="form-control" placeholder="Size name">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror

                    <textarea wire:model="description" class="form-control mt-2" placeholder="Description"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancel </button>
                    <input class="btn btn-outline-success" type="submit" value=" {{__('Dashboard/services.save')}} ">
                </div>
            </div>
        </div>
    </form>
</div>

{{-- <div wire:ignore.self class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> {{__('Dashboard/services.Deleteinvoicedata')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{__('Dashboard/services.surdelete')}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> {{__('Dashboard/services.close')}} </button>
                <button type="button" wire:click.prevent="destroy()" class="btn btn-danger"> {{__('Dashboard/services.delete')}} </button>
            </div>

        </div>
    </div>
</div> --}}
