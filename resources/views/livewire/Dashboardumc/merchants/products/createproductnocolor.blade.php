                    <div>
                        <div class="container">
                            <h3>إضافة منتج</h3>

                            @if (session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form wire:submit.prevent="save" enctype="multipart/form-data">

                                <div class="mb-2">
                                    <label>اسم المنتج</label>
                                    <input type="text" wire:model.defer="name" class="form-control">
                                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-2">
                                    <label>الوصف</label>
                                    <textarea wire:model.defer="description" class="form-control"></textarea>
                                </div>

                                <div class="mb-2">
                                    <label>الصورة</label>
                                    <input type="file" wire:model="image" class="form-control">
                                    @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-2">
                                    <label>السعر</label>
                                    <input type="number" step="0.01" wire:model.defer="price" class="form-control">
                                    @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-2">
                                    <label>الكمية</label>
                                    <input type="number" wire:model.defer="quantity" class="form-control">
                                    @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-2">
                                    <label>الحالة</label>
                                    <select wire:model.defer="status" class="form-control">
                                        <option value="1">نشط</option>
                                        <option value="0">غير نشط</option>
                                    </select>
                                </div>

                                <button class="btn btn-primary mt-2">
                                    حفظ
                                </button>
                            </form>
                        </div>
                    </div>
