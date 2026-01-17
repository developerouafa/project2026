<div wire:ignore.self class="modal fade" tabindex="-1" id="edit_sizes" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <form wire:submit.prevent="edit">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Add </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="size_id" id="size_id" wire:model="size_id">
                    <input type="text" wire:model="name" name="name" class="form-control" placeholder="Size name"  id="name">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror

                    <textarea wire:model="description" name="description" class="form-control mt-2" placeholder="Description" id="description"></textarea>
                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancel </button>
                    <button type="submit" class="btn btn-secondary"> Edit </button>
                </div>
            </div>
        </div>
    </form>
</div>
