				<!-- row -->
				<div class="row row-sm">
					<div class="col-xl-12">
						<div class="card">
							<div class="card-body h-100">
								<div class="row row-sm ">
									<div class=" col-xl-5 col-lg-12 col-md-12">
                                        <div class="preview-pic tab-content">

                                            {{-- الصورة الرئيسية (image من products) --}}
                                            <div class="tab-pane active" id="pic-main">
                                                <img src="{{ asset('storage/'.$productData->image) }}" alt="image">
                                            </div>

                                            {{-- الصور الإضافية --}}
                                            @foreach($productData->multiImages as $index => $img)
                                                <div class="tab-pane" id="pic-{{ $index }}">
                                                    <img src="{{ asset('storage/'.$img->multi_image) }}" alt="image">
                                                </div>
                                            @endforeach

                                        </div>

                                        <ul class="preview-thumbnail nav nav-tabs">

                                            {{-- Thumbnail الصورة الرئيسية --}}
                                            <li class="active">
                                                <a data-toggle="tab" href="#pic-main">
                                                    <img src="{{ asset('storage/'.$productData->image) }}" alt="image">
                                                </a>
                                            </li>

                                            {{-- Thumbnails الصور الإضافية --}}
                                            @foreach($productData->multiImages as $index => $img)
                                                <li>
                                                    <a data-toggle="tab" href="#pic-{{ $index }}">
                                                        <img src="{{ asset('storage/'.$img->multi_image) }}" alt="image">
                                                    </a>
                                                </li>
                                            @endforeach

                                        </ul>


									</div>
									<div class="details col-xl-7 col-lg-12 col-md-12 mt-4 mt-xl-0">
										<h4 class="product-title mb-1">{{ $productData->name }}</h4>
										<p class="text-muted tx-13 mb-1">
                                            @if($productData->finalQuantity() > 0)
                                                Quantity : {{ number_format($productData->finalQuantity()) }}
                                            @else
                                                <span class="text-danger font-weight-bold">Stock Faible</span>
                                            @endif
                                        </p>

                                        <div class="rating mb-1">
                                            <div class="stars">
                                                @for($i=1; $i<=5; $i++)
                                                    <span class="fa fa-star {{ $i <= $averageStars ? 'checked' : 'text-muted' }}"></span>
                                                @endfor
                                            </div>
                                            <span class="review-no">{{ $reviewsCount }} reviews</span>
                                        </div>
                                        <h4 class="price">
                                            @if($productData->currentPromotion)
                                                <span class="text-danger font-weight-bold">
                                                    ${{ number_format($productData->currentPromotion->price, 2) }}
                                                </span>
                                                <span class="text-muted" style="text-decoration: line-through;">
                                                    ${{ number_format($productData->finalPrice(), 2) }}
                                                </span>
                                            @else
                                                <span>${{ number_format($productData->finalPrice(), 2) }}</span>
                                            @endif
                                        </h4>
										<p class="product-description">{{ $productData->description }}</p>
										<p class="vote"><strong>91%</strong> of buyers enjoyed this product! <strong>(87 votes)</strong></p>

                                            @php
                                                use Illuminate\Support\Str;
                                                $colors = $productData->getAvailableSizes();
                                            @endphp

                                            @if(count($colors))

                                                {{-- ================= COLORS TABS ================= --}}
                                                <ul class="nav nav-tabs mb-3">
                                                    @foreach($colors as $colorName => $data)
                                                        <li class="nav-item">
                                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                                                            data-toggle="tab"
                                                            href="#color-{{ Str::slug($colorName) }}">
                                                                {{ $colorName }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>

                                                <div class="tab-content">

                                                    {{-- ================= COLOR CONTENT ================= --}}
                                                    @foreach($colors as $colorName => $data)
                                                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                                            id="color-{{ Str::slug($colorName) }}">

                                                            {{-- ============ WITH VARIANTS ============ --}}
                                                            @if(isset($data['variants']))
                                                                <div class="accordion" id="accordion-{{ Str::slug($colorName) }}">

                                                                    @foreach($data['variants'] as $variantName => $sizes)
                                                                        <div class="card mb-2">
                                                                            <div class="card-header p-2">
                                                                                <button class="btn btn-link"
                                                                                    data-toggle="collapse"
                                                                                    data-target="#variant-{{ Str::slug($colorName.$variantName) }}">
                                                                                    {{ $variantName }}
                                                                                </button>
                                                                            </div>

                                                                            <div id="variant-{{ Str::slug($colorName.$variantName) }}"
                                                                                class="collapse {{ $loop->first ? 'show' : '' }}"
                                                                                data-parent="#accordion-{{ Str::slug($colorName) }}">

                                                                                <div class="card-body">
                                                                                    <div class="d-flex flex-wrap">

                                                                                    @foreach($sizes as $size)
                                                                                        @php
                                                                                            $key = $colorName.'|'.$variantName.'|'.$size['size'];
                                                                                        @endphp

                                                                                        <div class="border rounded p-2 m-1" style="min-width:200px">
                                                                                            <label class="d-flex align-items-center mb-1">
                                                                                                <input type="checkbox"
                                                                                                    wire:change="toggleSelection('{{ $key }}', $event.target.checked)"
                                                                                                    wire:click="$toggle('selected.{{ $key }}')">
                                                                                                <strong class="ml-2">{{ $size['size'] }}</strong>
                                                                                            </label>

                                                                                            @if(array_key_exists($key, $selected))
                                                                                                <div class="d-flex align-items-center">
                                                                                                    <input type="number"
                                                                                                        min="1"
                                                                                                        max="{{ $size['quantity'] }}"
                                                                                                        wire:model.lazy="selected.{{ $key }}"
                                                                                                        wire:change="updateQuantity('{{ $key }}')"
                                                                                                        class="form-control form-control-sm"
                                                                                                        style="width:70px">
                                                                                                    <small class="ml-2 text-muted">
                                                                                                        / {{ $size['quantity'] }}
                                                                                                    </small>
                                                                                                </div>
                                                                                            @endif

                                                                                            <small class="text-success d-block mt-1">
                                                                                                ${{ number_format($size['price'],2) }}
                                                                                            </small>
                                                                                        </div>

                                                                                    @endforeach

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach

                                                                </div>
                                                            @endif

                                                            {{-- ============ WITHOUT VARIANTS ============ --}}
                                                            @if(isset($data['sizes']))
                                                                <div class="d-flex flex-wrap">

                                                                    @foreach($data['sizes'] as $size)
                                                                        @php
                                                                            $key = $colorName.'|'.$size['size'];
                                                                        @endphp

                                                                        <div class="border rounded p-2 m-1" style="min-width:200px">
                                                                            <label class="d-flex align-items-center mb-1">
                                                                                <input type="checkbox"
                                                                                    wire:change="toggleSelection('{{ $key }}', $event.target.checked)"
                                                                                    wire:click="$toggle('selected.{{ $key }}')">
                                                                                <strong class="ml-2">{{ $size['size'] }}</strong>
                                                                            </label>

                                                                            @if(array_key_exists($key, $selected))
                                                                                <div class="d-flex align-items-center">
                                                                                    <input type="number"
                                                                                        min="1"
                                                                                        max="{{ $size['quantity'] }}"
                                                                                        wire:model.lazy="selected.{{ $key }}"
                                                                                        wire:change="updateQuantity('{{ $key }}')"
                                                                                        class="form-control form-control-sm"
                                                                                        style="width:70px">
                                                                                    <small class="ml-2 text-muted">
                                                                                        / {{ $size['quantity'] }}
                                                                                    </small>
                                                                                </div>
                                                                            @endif

                                                                            <small class="text-success d-block mt-1">
                                                                                ${{ number_format($size['price'],2) }}
                                                                            </small>
                                                                        </div>

                                                                    @endforeach

                                                                </div>
                                                            @endif

                                                        </div>
                                                    @endforeach

                                                </div>

                                                {{-- ================= SUMMARY ================= --}}
                                                @if(count($selected))
                                                    <div class="alert alert-success mt-4">
                                                        <strong>Selected Products:</strong>
                                                        <ul class="mb-1">
                                                            @foreach($selected as $key => $qty)
                                                                <li>{{ $key }} → Qty: {{ $qty }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @else
                                                    <span class="text-danger font-weight-bold">
                                                        Select One Product
                                                    </span>
                                                @endif


                                            @else
                                                <div class="d-flex  mt-2">
                                                    <div class="mt-2 product-title">Quantity:</div>
                                                    <div class="d-flex ml-2">
                                                        <ul class="mb-0 qunatity-list">
                                                            <li>
                                                                <div class="form-group">
                                                                    <select name="quantity" wire:model="selectedQuantity" class="form-control nice-select wd-100">
                                                                        @php
                                                                            $maxQty = $productData->finalQuantity();
                                                                        @endphp

                                                                        @if($maxQty > 0)
                                                                            @for($i = 1; $i <= $maxQty; $i++)
                                                                                <option value="{{ $i }}">{{ $i }}</option>
                                                                            @endfor
                                                                        @else
                                                                            <option value="0"> Not available in stock </option>
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endif

										<div class="action">
											<button class="add-to-cart btn btn-success" type="button">ADD TO CART</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /row -->

				<!-- row -->
				<div class="row">
					<div class="col-lg-3">
						<div class="card item-card">
							<div class="card-body pb-0 h-100">
								<div class="text-center" wire:click="show_details({{ $productData->id }})">
                                    @if(empty($productData->image))
                                        <img class="w-100" src="{{URL::asset('assets/img/ecommerce/01.jpg')}}" alt="product-image">
                                    @else
                                        <img src="{{ asset('storage/'.$productData->image) }}" alt="image" class="img-fluid">
                                    @endif
								</div>
								<div class="card-body cardbody relative">
									<div class="cardtitle">
										<span>Price</span>
										<a>Promotion</a>
									</div>
                                    <div class="cardprice">
                                        @if($productData->currentPromotion)
                                            <span class="text-danger font-weight-bold">
                                                ${{ number_format($productData->currentPromotion->price, 2) }}
                                            </span>
                                            <span class="text-muted" style="text-decoration: line-through;">
                                                ${{ number_format($productData->finalPrice(), 2) }}
                                            </span>
                                        @else
                                            <span>${{ number_format($productData->finalPrice(), 2) }}</span>
                                        @endif
                                    </div>
								</div>
							</div>
							<div class="text-center border-top pt-3 pb-3 pl-2 pr-2 ">
								<a href="#" class="btn btn-primary"> View More</a>
								<a href="#" class="btn btn-success"><i class="fa fa-shopping-cart"></i> Add to cart</a>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="card item-card">
							<div class="card-body pb-0 h-100">
								<div class="text-center">
									<img src="{{URL::asset('assets/img/ecommerce/04.jpg')}}" alt="img" class="img-fluid">
								</div>
								<div class="card-body cardbody relative">
									<div class="cardtitle">
										<span>Fashion</span>
										<a>Mens Shoes</a>
									</div>
									<div class="cardprice">
										<span class="type--strikethrough">$999</span>
										<span>$799</span>
									</div>
								</div>
							</div>
							<div class="text-center border-top pt-3 pb-3 pl-2 pr-2 ">
								<a href="#" class="btn btn-primary"> View More</a>
								<a href="#" class="btn btn-success"><i class="fa fa-shopping-cart"></i> Add to cart</a>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="card item-card">
							<div class="card-body pb-0 h-100">
								<div class="text-center">
									<img src="{{URL::asset('assets/img/ecommerce/07.jpg')}}" alt="img" class="img-fluid">
								</div>
								<div class="card-body cardbody relative ">
									<div class="cardtitle">
										<span>Accessories</span>
										<a>Metal Watch</a>
									</div>
									<div class="cardprice">
										<span class="type--strikethrough">$999</span>
										<span>$799</span>
									</div>
								</div>
							</div>
							<div class="text-center border-top pt-3 pb-3 pl-2 pr-2 ">
								<a href="#" class="btn btn-primary"> View More</a>
								<a href="#" class="btn btn-success"><i class="fa fa-shopping-cart"></i> Add to cart</a>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="card item-card">
							<div class="card-body pb-0 h-100">
								<div class="text-center">
									<img src="{{URL::asset('assets/img/ecommerce/08.jpg')}}" alt="img" class="img-fluid">
								</div>
								<div class="card-body cardbody relative">
									<div class="cardtitle">
										<span>Accessories</span>
										<a>Metal Watch</a>
									</div>
									<div class="cardprice">
										<span class="type--strikethrough">$999</span>
										<span>$799</span>
									</div>
								</div>
							</div>
							<div class="text-center border-top pt-3 pb-3 pl-2 pr-2 ">
								<a href="#" class="btn btn-primary"> View More</a>
								<a href="#" class="btn btn-success"><i class="fa fa-shopping-cart"></i> Add to cart</a>
							</div>
						</div>
					</div>
				</div>
				<!-- /row -->
