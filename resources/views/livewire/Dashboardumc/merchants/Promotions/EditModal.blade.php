<!-- Modal -->
<div class="modal fade" id="edit{{$promotion->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Edit Promotions </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="Number" wire:model="price" class="form-control" placeholder="Price Promotion">
                @error('price') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="modal-body">
                <input type="date" wire:model="start_time" class="form-control" placeholder="Start_Time Promotion">
                @error('start_time') <span class="text-danger">{{ $message }}</span> @enderror
                <br>
                <input type="date" wire:model="end_time" class="form-control" placeholder="End_Time Promotion">
                @error('end_time') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Close </button>
                    <button type="button" wire:click="update({{ $promotion->id }})" class="btn btn-danger"> Update </button>
                </div>
        </div>
    </div>
</div>
