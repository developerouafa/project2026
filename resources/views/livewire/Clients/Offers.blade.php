<div class="container">
    {{-- 📦 Packages --}}
    <div class="row">
        @forelse($packages as $package)
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">

                    <div class="card-body">

                        <h5 class="card-title">
                            {{ $package->name }}
                        </h5>

                        <p class="text-muted">
                            {{ $package->notes }}
                        </p>

                        {{-- 🛍 Products --}}
                        <ul class="list-group mb-3">
                            @foreach($package->products as $product)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>
                                        {{ $product->name }}
                                        <small class="text-muted">
                                            × {{ $product->pivot->quantity }}
                                        </small>
                                    </span>
                                    <span>
                                        {{ $product->price * $product->pivot->quantity }} DH
                                    </span>
                                </li>
                            @endforeach
                        </ul>

                        {{-- 💰 Totals --}}
                        <div class="border-top pt-2">
                            <p>Befor Promotion :
                                <strong>{{ $package->Total_before_discount }} DH</strong>
                            </p>

                            <p class="text-danger">
                                Promotion :
                                -{{ $package->discount_value }} DH
                            </p>

                            <p>
                                After Promotion :
                                <strong>{{ $package->Total_after_discount }} DH</strong>
                            </p>

                            <p>
                                Tax ({{ $package->tax_rate }}%):
                                <strong>
                                    {{ $package->Total_with_tax - $package->Total_after_discount }} DH
                                </strong>
                            </p>

                            <h5 class="text-success">
                                Total :
                                {{ $package->Total_with_tax }} DH
                            </h5>
                        </div>

                    </div>

                    <div class="card-footer text-center">
                        <button class="btn btn-primary w-100">
                            🛒 Add To Cart
                        </button>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted">
              No Package Product
            </div>
        @endforelse
    </div>
</div>
