

            <div>
                {{-- ================= Page Products ================= --}}
                @if($show_products)
                    @include('livewire.Clients.DetailsProduct')

                {{-- ================= Details Products ================= --}}
                @else
                    <div class="breadcrumb-header justify-content-between">
                        <div class="my-auto">
                            <div class="d-flex">
                                <h4 class="content-title mb-0 my-auto">Ecommerce</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Products</span>
                            </div>
                        </div>
                        <div class="d-flex my-xl-auto right-content">

                            <div class="pr-1 mb-3 mb-xl-0">
                                <button type="button" class="btn btn-warning btn-icon ml-2" wire:click="resetFilters">
                                    <i class="mdi mdi-refresh"></i>
                                </button>
                            </div>
                            <div class="mb-3 mb-xl-0">
                                <div class="btn-group dropdown">
                                    <button type="button" class="btn btn-primary">Date</button>
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuDate"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="sr-only">Year Products</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuDate" data-x-placement="bottom-end">
                                        @foreach ($years as $y)
                                            <a class="dropdown-item"
                                            href="#"
                                            wire:click.prevent="$set('year', {{ $y }})">
                                                {{ $y }}
                                            </a>
                                        @endforeach

                                        <div class="dropdown-divider"></div>

                                        <a class="dropdown-item text-danger"
                                        href="#"
                                        wire:click.prevent="$set('year', null)">
                                        All Years
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- breadcrumb -->

                    <!-- row -->
                    <div class="row row-sm">


                        <div class="col-xl-3 col-lg-3 col-md-12 mb-3 mb-md-0">
                            <div class="card">
                                <div class="card-header border-bottom pt-3 pb-3 mb-0 font-weight-bold text-uppercase">Category</div>
                                <div class="card-body pb-0">
                                    <div class="form-group mt-2">
                                        <label>Section</label>
                                        <select wire:model.live="parent_id" class="form-control">
                                            <option value="">Choose section</option>

                                            @foreach ($sections as $section)
                                                {{-- parent section --}}
                                                <optgroup label="{{ $section->name }}">
                                                    @foreach ($section->subsections as $child)
                                                        <option value="{{ $child->id }}">
                                                            {{ $child->name }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach

                                        </select>
                                    </div>

                                    <div class="form-group mt-2">
                                            <label>Min Price</label>
                                            <input type="number" wire:model.live="minPrice" class="form-control mb-2">

                                            <label>Max Price</label>
                                            <input type="number" wire:model.live="maxPrice" class="form-control mb-2">
                                    </div>

                                    <div class="form-group mt-2">
                                            <label> Promotions </label>
                                            <select wire:model.live="discountFilter" class="form-control">
                                                <option value=""> All Products </option>
                                                <option value="1"> Exist Promotion </option>
                                                <option value="0"> No Promotion </option>
                                            </select>
                                    </div>
                                    <div class="form-group mt-2">
                                            <label>Filter by Color</label>

                                            <select class="form-control" wire:model.live="color_id">
                                                <option value="">-- All Color --</option>

                                                @foreach ($colors as $color)
                                                    <option value="{{ $color->id }}">
                                                        {{ $color->name }}
                                                    </option>
                                                @endforeach

                                                <option value="none"> Products No Color </option>
                                            </select>
                                    </div>
                                </div>
                                <div class="card-header border-bottom border-top pt-3 pb-3 mb-0 font-weight-bold text-uppercase">Filter</div>
                                <div class="card-body">
                                    <form role="form product-form">
                                        <div class="form-group">
                                            <label>Sizes</label>
                                            <select class="form-control" wire:model.live="size_id">
                                                <option value="">--  Select Size --</option>
                                                @foreach ($sizes as $size)
                                                    <option value="{{ $size->id }}">
                                                        {{ $size->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-header border-bottom border-top pt-3 pb-3 mb-0 font-weight-bold text-uppercase">
                                    Rating
                                </div>

                                <div class="py-2 px-3">

                                    @foreach ([5,4,3,2,1] as $star)
                                        <label class="p-1 mt-2 d-flex align-items-center">

                                            <span class="check-box mb-0">
                                                <span class="ckbox">
                                                    <input checked="" type="checkbox"
                                                    wire:model.live="ratings"
                                                    value="{{ $star }}"
                                                    class="mr-2">
                                                <span></span></span>
                                            </span>
                                            @for ($i = 0; $i < $star; $i++)
                                                <span class="ml-3 tx-16 my-auto">
                                                    <i class="ion ion-md-star text-warning"></i>
                                                </span>
                                            @endfor
                                        </label>
                                    @endforeach
                                    <button class="btn btn-primary-gradient mt-2 mb-2 pb-2" wire:click="$set('ratings', [])">
                                        Reset
                                    </button>
                                </div>


                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-12">
                            <div class="card">
                                <div class="card-body p-2">
                                    <div class="input-group">
                                        <input type="text" wire:model.live="search" class="form-control" placeholder="Search ...">
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm">

                                @forelse ($products as $product)

                                        <div class="col-md-6 col-lg-6 col-xl-4  col-sm-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="pro-img-box">
                                                        <div class="d-flex product-sale">
                                                            <button
                                                                wire:click="show_details({{ $product->id }})"
                                                                type="button"
                                                                class="btn p-0 border-0 bg-transparent text-reset"
                                                            >
                                                                View
                                                            </button>
                                                        </div>
                                                        @if(empty($product->image))
                                                            <img class="w-100" src="{{URL::asset('assets/img/ecommerce/01.jpg')}}" alt="product-image">
                                                        @else
                                                            <img src="{{ asset('storage/'.$product->image) }}" class="w-12 h-12">
                                                        @endif
                                                        <a href="#" class="adtocart"> <i class="las la-shopping-cart "></i>
                                                        </a>
                                                    </div>
                                                    <div class="text-center pt-3">
                                                        <h3 class="h6 mb-2 mt-4 font-weight-bold text-uppercase" wire:click="show_details({{ $product->id }})">{{ $product->name }}</h3>
                                                        <span class="tx-15 ml-auto">

                                                            @php
                                                                $rating = $product->average_rating;
                                                                $full = floor($rating);
                                                                $half = ($rating - $full) >= 0.5;
                                                                $empty = 5 - $full - ($half ? 1 : 0);
                                                            @endphp

                                                            <span class="tx-15">

                                                                {{-- ⭐ كاملة --}}
                                                                @for ($i = 0; $i < $full; $i++)
                                                                    <i class="ion ion-md-star text-warning"></i>
                                                                @endfor

                                                                {{-- ⭐ نصف --}}
                                                                @if ($half)
                                                                    <i class="ion ion-md-star-half text-warning"></i>
                                                                @endif

                                                                {{-- ☆ فارغة --}}
                                                                @for ($i = 0; $i < $empty; $i++)
                                                                    <i class="ion ion-md-star-outline text-warning"></i>
                                                                @endfor

                                                            </span>

                                                            <small class="text-muted">
                                                                ({{ $product->ratings_count }} Rating)
                                                            </small>

                                                        </span>
                                                        <h4 class="h5 mb-0 mt-2 text-center font-weight-bold text-danger">
                                                            @if($product->currentPromotion)
                                                                <span class="text-danger font-weight-bold">
                                                                    ${{ number_format($product->currentPromotion->price, 2) }}
                                                                </span>
                                                                <span class="text-muted" style="text-decoration: line-through;">
                                                                    ${{ number_format($product->finalPrice(), 2) }}
                                                                </span>
                                                            @else
                                                                <span>${{ number_format($product->finalPrice(), 2) }}</span>
                                                            @endif
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">NO Products</td>
                                    </tr>
                                @endforelse
                                <div class="col-lg-12 col-md-12">
                                    <div class="d-flex justify-content-start mt-4">
                                        {{ $products->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- row closed -->
                @endif
            </div>
