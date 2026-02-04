<div  wire:ignore.self class="modal fade" tabindex="-1" id="add_products" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5>{{ 'Edit Product'  }}</h5>
                <input type="hidden" wire:model="product_id">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form wire:submit.prevent="updateProduct" enctype="multipart/form-data">
                {{-- @csrf --}}
                <div class="row">

                    <h5>{{ $product_id ? 'Edit Products' : 'Add Size' }}</h5>
                    <input type="hidden" wire:model="product_id">

                    <div class="col-lg-6">
                        <label> Name </label>
                        <input type="text" wire:model.defer="name" class="form-control">
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-lg-6">
                        <label> Description </label>
                        <textarea wire:model.defer="description" class="form-control"></textarea>
                    </div>

                    <div class="col-lg-6">
                        <label> Image </label>
                        <input type="file" wire:model="image" class="form-control">
                        @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-lg-6">
                        <label> Price </label>
                        <input type="number" step="0.01" wire:model.defer="price" class="form-control">
                        @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-lg-6">
                        <label> Quantity </label>
                        <input type="number" wire:model.defer="quantity" class="form-control">
                        @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-lg-12">
                        <label> Status </label>
                        <select wire:model.defer="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">No Active</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
