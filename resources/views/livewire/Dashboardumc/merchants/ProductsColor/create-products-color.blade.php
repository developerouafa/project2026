<div>

    {{-- ================= ALERTS ================= --}}
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ================= TABLE ================= --}}
    @if($show_table)
        @include('livewire.Dashboardumc.merchants.ProductsColor.index')

    {{-- ================= FORM ================= --}}
    @else
        <form wire:submit.prevent="saveProductColor" autocomplete="off">

            {{-- ================= PRODUCT INFO ================= --}}
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Name English</label>
                            <input type="text" wire:model.defer="name_en" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label>Name Arabic</label>
                            <input type="text" wire:model.defer="name_ar" class="form-control">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label>Description English</label>
                            <textarea wire:model.defer="description_en" class="form-control" rows="4"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label>Description Arabic</label>
                            <textarea wire:model.defer="description_ar" class="form-control" rows="4"></textarea>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label>Main Image</label>
                            <input type="file" wire:model="image" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label>Section</label>
                            <select wire:model.defer="parent_id" class="form-control">
                                <option value="">Choose section</option>
                                @foreach ($sections as $section)
                                    @foreach ($section->subsections as $child)
                                        <option value="{{ $child->id }}">
                                            {{ $child->name }} ({{ $section->name }})
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= MULTI IMAGES ================= --}}
            <div class="card mb-4">
                <div class="card-header">
                    <button type="button" class="btn btn-outline-primary" wire:click="addImage">Add Image</button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th width="200">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($images as $index => $image)
                                <tr>
                                    <td>
                                        @if($image['is_saved'])
                                            <img src="{{ asset('storage/'.$image['path']) }}" width="120">
                                        @else
                                            <input type="file"
                                                wire:model="images.{{ $index }}.file"
                                                class="form-control">
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$image['is_saved'] && $image['file'])
                                            <button type="button"
                                                class="btn btn-success btn-sm"
                                                wire:click="saveImage({{ $index }})">Save</button>
                                        @endif

                                        <button type="button"
                                            class="btn btn-danger btn-sm"
                                            wire:click="removeImage({{ $index }})">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ================= VARIANTS ================= --}}
            <div class="card mb-4">
                <div class="card-body">

                    {{-- Toggle Has Secondary Colors --}}
                    <label class="fw-bold">Has secondary colors?</label>
                    <div class="mb-3">
                        <button type="button"
                                class="btn btn-sm {{ !$has_variants ? 'btn-primary' : 'btn-outline-secondary' }}"
                                wire:click="toggleVariant(false)">No</button>

                        <button type="button"
                                class="btn btn-sm {{ $has_variants ? 'btn-primary' : 'btn-outline-secondary' }}"
                                wire:click="toggleVariant(true)">Yes</button>
                    </div>

                    {{-- Primary Colors --}}
                    @foreach($colors_with_sizes as $color_index => $color)
                        <div class="border p-3 mb-3">

                            <div class="d-flex gap-2 mb-2">
                                <select class="form-control"
                                    wire:model="colors_with_sizes.{{ $color_index }}.color_id">
                                    <option value="">Choose color</option>
                                    @foreach($all_colors as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>

                                <button type="button"
                                    class="btn btn-danger btn-sm"
                                    wire:click="removeColor({{ $color_index }})">X</button>
                            </div>

                            {{-- Sizes for primary color --}}
                            @foreach($color['sizes'] ?? [] as $size_index => $size)
                                <div class="d-flex gap-2 mb-2">
                                    <select class="form-control"
                                        wire:model="colors_with_sizes.{{ $color_index }}.sizes.{{ $size_index }}.size_id">
                                        <option value="">Size</option>
                                        @foreach($all_sizes as $s)
                                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                                        @endforeach
                                    </select>

                                    <input type="number" class="form-control"
                                        placeholder="Qty"
                                        wire:model="colors_with_sizes.{{ $color_index }}.sizes.{{ $size_index }}.quantity">

                                    <input type="number" class="form-control"
                                        placeholder="Price"
                                        wire:model="colors_with_sizes.{{ $color_index }}.sizes.{{ $size_index }}.price">

                                    <button type="button"
                                        class="btn btn-danger btn-sm"
                                        wire:click="removeSize({{ $color_index }}, {{ $size_index }})">X</button>
                                </div>
                            @endforeach

                            <button type="button"
                                class="btn btn-sm btn-outline-primary"
                                wire:click="addSize({{ $color_index }})">Add Size</button>

                            {{-- ================= Secondary Colors ================= --}}
                            @if($has_variants)
                                @foreach($color['secondary_colors'] ?? [] as $sec_index => $secColor)
                                    <div class="border p-2 mb-2 bg-light ms-3">

                                        <div class="d-flex gap-2 mb-2">
                                            <select class="form-control"
                                                wire:model="colors_with_sizes.{{ $color_index }}.secondary_colors.{{ $sec_index }}.color_id">
                                                <option value="">Choose secondary color</option>
                                                @foreach($all_colors as $c)
                                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                                @endforeach
                                            </select>

                                            <button type="button" class="btn btn-danger btn-sm"
                                                wire:click="removeSecondaryColor({{ $color_index }}, {{ $sec_index }})">X</button>
                                        </div>

                                        {{-- Sizes for secondary color --}}
                                        @foreach($secColor['sizes'] ?? [] as $size_index => $size)
                                            <div class="d-flex gap-2 mb-2 ms-3">
                                                <select class="form-control"
                                                    wire:model="colors_with_sizes.{{ $color_index }}.secondary_colors.{{ $sec_index }}.sizes.{{ $size_index }}.size_id">
                                                    <option value="">Size</option>
                                                    @foreach($all_sizes as $s)
                                                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                                                    @endforeach
                                                </select>

                                                <input type="number" class="form-control"
                                                    placeholder="Qty"
                                                    wire:model="colors_with_sizes.{{ $color_index }}.secondary_colors.{{ $sec_index }}.sizes.{{ $size_index }}.quantity">

                                                <input type="number" class="form-control"
                                                    placeholder="Price"
                                                    wire:model="colors_with_sizes.{{ $color_index }}.secondary_colors.{{ $sec_index }}.sizes.{{ $size_index }}.price">

                                                <button type="button" class="btn btn-danger btn-sm"
                                                    wire:click="removeSize({{ $color_index }}, {{ $size_index }}, {{ $sec_index }})">X</button>
                                            </div>
                                        @endforeach

                                        <button type="button" class="btn btn-sm btn-outline-primary ms-3"
                                            wire:click="addSize({{ $color_index }}, {{ $sec_index }})">Add Size</button>

                                    </div>
                                @endforeach

                                <button type="button" class="btn btn-sm btn-secondary"
                                    wire:click="addSecondaryColor({{ $color_index }})">Add Secondary Color</button>
                            @endif

                        </div>
                    @endforeach

                    <button type="button" class="btn btn-success btn-sm"
                        wire:click="addColor">Add Color</button>

                </div>
            </div>

            {{-- ================= SAVE BUTTON ================= --}}
            <div class="text-end">
                <button type="submit" class="btn btn-lg btn-primary">Save Product</button>
            </div>

        </form>
    @endif
</div>
