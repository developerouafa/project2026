<div class="modal fade show d-block" tabindex="-1">
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
<div class="modal-backdrop fade show"></div>
