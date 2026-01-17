                    <div>
                            <h3> Add Product No color </h3>

                            @if (session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form wire:submit.prevent="save" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
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
                                        <label for="inputName" class="control-label">Sections</label>
                                        <select name="children" class="form-control SlectBox">
                                            <option value="" selected disabled> Child Section </option>
                                            @foreach ($sections as $section)
                                                @foreach ($section->subsections as $child)
                                                    <option value="{{ $child->id }}">{{ $child->name }} ({{ $section->name }})</option>
                                                @endforeach
                                            @endforeach
                                        </select>
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

                                    <button class="btn btn-primary mt-2">
                                        Save
                                    </button>
                                </div>
                            </form>
                    </div>
