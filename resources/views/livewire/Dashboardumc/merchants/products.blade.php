<div>
    <div class="flex justify-between mb-4">
        <input type="text" wire:model.live="search" placeholder="بحث باسم المنتج..."
               class="border p-2 rounded">

        {{-- <a href="{{ route('products.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded">+ منتج جديد</a> --}}
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="example" class="table key-buttons text-md-nowrap" data-page-length="50" style="text-align: center">
                <thead class="bg-gray-100">
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Section</th>
                        <th>Child</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr class="border-b">
                        <td>
                            <img src="{{ asset('storage/'.$product->image) }}" class="w-12 h-12">
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->section->name }}</td>
                        <td>{{ $product->subsections->name }}</td>
                        <td>{{ $product->price }} DH</td>
                        <td>{{ $product->quantity }}</td>
                        <td>
                            @if($product->in_stock)
                                <span class="text-green-600">متوفر</span>
                            @else
                                <span class="text-red-600">غير متوفر</span>
                            @endif
                        </td>
                        <td class="flex gap-2">
                            {{-- <a href="{{ route('products.edit',$product->id) }}" class="text-blue-600">تعديل</a>
                            <a href="{{ route('products.images',$product->id) }}" class="text-purple-600">صور</a> --}}
                            {{-- <button wire:click="delete({{ $product->id }})" class="text-red-600">حذف</button> --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
