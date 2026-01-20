<div  wire:ignore.self class="modal fade" tabindex="-1" id="Add" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5>{{ 'Add Promotion' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="Number" wire:model="price" class="form-control" placeholder="Price Promotion">
                @error('price') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="modal-body">
                                                <select name="products"
                                                        class="form-control"
                                                        wire:model="product_id">
                                                    <option value="">-- Products --</option>
                                                    @foreach ($Products as $product)
                                                        <option value="{{ $product->id }}">
                                                            {{ $product->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                @error('product') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="modal-body">
                <input type="date" wire:model="start_time" class="form-control" placeholder="Start_Time Promotion">
                @error('start_time') <span class="text-danger">{{ $message }}</span> @enderror
                <br>
                <input type="date" wire:model="end_time" class="form-control" placeholder="End_Time Promotion">
                @error('end_time') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" wire:click="store" data-dismiss="modal">Save</button>
            </div>

        </div>
    </div>
</div>
<!-- Modal -->
