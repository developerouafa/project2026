<div>
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

    <!-- row opened -->
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Shopping Cart-->
                        <div class="product-details table-responsive text-nowrap">
                            <table class="table table-bordered table-hover mb-0 text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th class="w-150">Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                        <th>
                                            <button class="btn btn-sm btn-outline-danger" wire:click="deleteall" type="button">
                                                Clear Cart
                                            </button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <td>
                                                <div class="media">
                                                    <div class="card-aside-img">

                                                        @if(empty($item->product->image))
                                                            <img class="h-60 w-60" src="{{URL::asset('assets/img/ecommerce/01.jpg')}}" alt="product-image">
                                                        @else
                                                            <img src="{{ asset('storage/'.$item->product->image) }}" class="h-60 w-60">
                                                        @endif
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="font-weight-semibold text-uppercase">
                                                            {{ $item->product->name }}
                                                        </h6>
                                                        <dl>Size:<dd>{{ $item->size }}</dd></dl>
                                                        <dl>Color:<dd>{{ $item->color }}</dd></dl>
                                                        @if($item->variant)
                                                            <dl>Variant:<dd>{{ $item->variant }}</dd></dl>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>

                                            {{-- Quantity --}}
                                            <td>
                                                @if($item->isOutOfStock())
                                                    <span class="text-danger font-weight-bold">Out of Stock</span>
                                                @else
                                                    <small class="ml-2 text-muted"> {{ $item->qty }} </small>
                                                    / Max In stock <span style="color:red"> {{ $item->getProductStock() }}</span>
                                                    <select
                                                        class="form-control"
                                                        wire:model="quantities.{{ $item->id }}"
                                                        wire:change="updateQuantity({{ $item->id }}, $event.target.value)"
                                                    >
                                                        @for($i = 1; $i <= $item->getProductStock(); $i++)
                                                            <option value="{{ $i }}">{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                ${{ number_format($item->price, 2) }}
                                            </td>

                                            {{-- Subtotal --}}
                                            <td class="text-center">
                                                ${{ number_format($item->price * $item->qty, 2) }}
                                            </td>

                                            <td class="text-center">
                                                <button type="button" wire:click="removeItem({{ $item->id }})" class="btn btn-sm">
                                                    <i class="fa fa-trash text-danger"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="shopping-cart-footer border-top-0">
                            <div class="column text-lg">
                                Subtotal:
                                <span class="tx-20 font-weight-bold">
                                    ${{ number_format($subtotal,2) }}
                                </span>
                            </div>
                        </div>

                        <div class="shopping-cart-footer">
                            <div class="column"><a class="btn btn-secondary" href="{{ route('Products.clients') }}">Back to Shopping</a></div>
                            <div class="column">
                                <a class="btn btn-success" href="#">Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- row closed -->
</div>
