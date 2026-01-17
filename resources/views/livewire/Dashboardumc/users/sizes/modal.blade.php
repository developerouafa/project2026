<div  wire:ignore.self class="modal fade" tabindex="-1" id="add_sizes" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5>{{ $size_id ? 'Edit Size' : 'Add Size' }}</h5>
                <input type="hidden" wire:model="size_id">
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
                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" wire:click="store" data-dismiss="modal">Save</button>
            </div>

        </div>
    </div>
</div>
<!-- Modal -->
