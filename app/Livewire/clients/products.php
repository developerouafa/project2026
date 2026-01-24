<?php

namespace App\Livewire\clients;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Colors;
use App\Models\Packageproducts;
use App\Models\Product;
use App\Models\Sections;
use App\Models\Sizes;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Exception;

class products extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $show_products = false;
    public $packageproducts = false;
    public $search = '';
    public $searchpackage = '';
    public
    $year = '',
    $ratings = [],
    $parent_id,
    $minPrice,
    $maxPrice,
    $pricepr,
    $hasColor = null,
    $discountFilter = null,
    $color_id,
    $size_id, $name, $description, $productData, $averageStars = 0, $reviewsCount = 0, $packages;

    public $selected = [];

    public $qty = 1;
    public $package_product_id = null;

    public function AddToCart()
    {
        // $this->productId = $productId;

        // // ناخدو الكلاينت الحالي
        // $client = Auth::guard('clients')->id();

        // if (!$client) {
        //     session()->flash('error', ' Error Login ');
        //     return;
        // }

        // // نشوفو واش كاينة cart مفتوحة
        // $cart = Cart::firstOrCreate(
        //     [
        //         'client_id' => $client,
        //         'merchant_id' => Product::find($productId)->merchant_id, // نحصلو على الميرشانت ديال المنتج
        //         'status' => 'active',
        //     ]
        // );

        // // نشوفو واش المنتج موجود من قبل فـ cart
        // $cartItem = $cart->items()->where('product_id', $productId)->first();

        // if ($cartItem) {
        //     // إذا كان موجود نزيدو الكمية
        //     $cartItem->qty += $this->qty;
        //     $cartItem->save();
        // } else {
        //     // إذا ماكانش موجود نضيفو الجديد
        //     $product = Product::findOrFail($productId);

        //     // Price
        //     if($product->currentPromotion){
        //         $price = $product->currentPromotion->price;
        //     }
        //     else{
        //         $price = $product->finalPrice();
        //     }

        //     $cart->items()->create([
        //         'product_id' => $productId,
        //         'price' => $price, // ثمن المنتج
        //     ]);
        // }
        //     session()->flash('success', ' Product added to cart successfully! ');

                // ---------------------------------------

        // if (empty($this->selected)) {
        //     $this->addError('cart', 'Select at least one product');
        //     return;
        // }

        // $clientId = Auth::guard('clients')->id(); // تأكد من guard

        // // 🛒 Get or create cart
        // $cart = Cart::firstOrCreate([
        //     'client_id'   => $clientId,
        //     'merchant_id' => $this->productData->merchant_id,
        // ]);

        // foreach ($this->selected as $key => $data) {

        //     $qty   = $data['qty'] ?? 0;
        //     $price = $data['price'] ?? $this->getPriceByKey($key);

        //     if ($qty < 1) continue;


        //         $stock = $this->getStockByKey($key);

        //         if ($data['qty'] > $stock) {
        //             session()->flash('error', 'Quantity exceeds stock');
        //             return;
        //         }

        //     // تحليل المفتاح
        //     $parts = explode('|', $key);

        //     $color   = $parts[0] ?? null;
        //     $variant = count($parts) === 3 ? $parts[1] : null;
        //     $size    = count($parts) === 3 ? $parts[2] : ($parts[1] ?? null);

        //     CartItem::create([
        //         'cart_id'    => $cart->id,
        //         'product_id' => $this->productData->id,
        //         'color'      => $color,
        //         'variant'    => $variant,
        //         'size'       => $size,
        //         'qty'   => $qty,
        //         'price'      => $price,
        //     ]);
        // }

        // // ✅ Reset
        // $this->selected = [];

        // session()->flash('success', 'Product added to cart successfully 🛒');


        // ________________________________________________________________

            if (empty($this->selected)) {
                session()->flash('error', 'Select at least one product');
                return;
            }

            try {

                DB::transaction(function () {

                    // ✅ تحقق كامل من stock قبل أي تسجيل
                    foreach ($this->selected as $key => $data) {

                        $qty = (int) ($data['qty'] ?? 0);
                        if ($qty < 1) {
                            throw new Exception('Invalid quantity');
                        }

                        $stock = $this->getStockByKey($key);

                        if ($qty > $stock) {
                            throw new Exception(
                                'Quantity exceeds stock. Available: ' . $stock
                            );
                        }
                    }

                    // ✅ دابا فقط نسمحو بالتسجيل
                    $clientId = Auth::guard('clients')->id();

                    $cart = Cart::firstOrCreate([
                        'client_id'   => $clientId,
                        'merchant_id' => $this->productData->merchant_id,
                    ]);

                    foreach ($this->selected as $key => $data) {

                        $qty   = (int) $data['qty'];
                        $price = $data['price'] ?? $this->getPriceByKey($key);

                        $parts = explode('|', $key);

                        $color   = $parts[0] ?? null;
                        $variant = count($parts) === 3 ? $parts[1] : null;
                        $size    = count($parts) === 3 ? $parts[2] : ($parts[1] ?? null);

                        CartItem::create([
                            'cart_id'    => $cart->id,
                            'product_id' => $this->productData->id,
                            'color'      => $color,
                            'variant'    => $variant,
                            'size'       => $size,
                            'qty'   => $qty,
                            'price'      => $price,
                        ]);
                    }

                });

                // ✅ غير إلا داز كلشي
                $this->selected = [];
                session()->flash('success', 'Product added to cart successfully 🛒');

            } catch (Exception $e) {

                // ❌ أي خطأ → rollback تلقائي
                session()->flash('error', $e->getMessage());
                return;
            }
    }

    private function getPriceByKey($key)
    {
        $parts = explode('|', $key);
        $color   = $parts[0] ?? null;
        $variant = count($parts) === 3 ? $parts[1] : null;
        $size    = count($parts) === 3 ? $parts[2] : ($parts[1] ?? null);

        $colors = $this->productData->getAvailableSizes();

        if ($variant && isset($colors[$color]['variants'][$variant][$size])) {
            return $colors[$color]['variants'][$variant][$size]['price'];
        }

        if (isset($colors[$color]['sizesf'][$size])) {
            return $colors[$color]['sizesf'][$size]['price'];
        }

        return $this->productData->price; // fallback
    }

    public function resetFilters()
    {
        $this->reset([
            'search',
            'year',
            'ratings',
            'parent_id',
            'color_id',
            'size_id',
            'minPrice',
            'maxPrice',
            'hasColor',
            'discountFilter',
        ]);

        // إلى كنتِ كتستعملي pagination
        $this->resetPage();
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function show_details($id)
    {
        $this->resetFilters();
        $this->show_products = true;

        $this->productData = Product::findOrFail($id);

        $this->reviewsCount = $this->productData->ratings->count();
        if($this->reviewsCount > 0){
            $this->averageStars = round($this->productData->ratings->avg('stars'));
        }
    }


    public function toggleSelection($key, $checked, $price)
    {
            if($checked) {
                $this->selected[$key] = [
                    'qty' => 1,
                    'price' => $price
                ];
            } else {
                unset($this->selected[$key]);
            }
    }

    public function updateQuantity($key, $qty)
    {
        if (!isset($this->selected[$key])) {
            return;
        }

        // stock ديال هاد الاختيار
        $stock = $this->getStockByKey($key);

        // تنظيف القيمة
        $qty = (int) $qty;

        if ($qty < 1) {
            $qty = 1;
        }

        if ($qty > $stock) {
            $qty = $stock;

                    session()->flash('error', 'Stock limité');

        }

        $this->selected[$key]['qty'] = $qty;
    }

    private function getStockByKey($key)
    {
        $parts = explode('|', $key);

        $color   = $parts[0] ?? null;
        $variant = count($parts) === 3 ? $parts[1] : null;
        $size    = count($parts) === 3 ? $parts[2] : ($parts[1] ?? null);

        $colors = $this->productData->getAvailableSizes();

        // WITH VARIANT
        if ($variant && isset($colors[$color]['variants'][$variant])) {
            foreach ($colors[$color]['variants'][$variant] as $s) {
                if ($s['size'] === $size) {
                    return (int) $s['quantity'];
                }
            }
        }

        // WITHOUT VARIANT
        if (isset($colors[$color]['sizesf'])) {
            foreach ($colors[$color]['sizesf'] as $s) {
                if ($s['size'] === $size) {
                    return (int) $s['quantity'];
                }
            }
        }

        return 0;
    }


    public function packageproduct()
    {
        $this->resetFilters();
        $this->packageproducts = true;


        $this->packages = Packageproducts::with([
                'products',
                'merchant'
            ])
            ->orderByDesc('id')
            ->get();
    }

    public function render()
    {
        // 🟢 جلب السنوات تلقائياً
        $years = Product::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $products = Product::where('name', 'like', '%' . $this->search . '%')
            ->withCount('ratings')
            ->withSum('ratings', 'stars')
            // فلترة بالسنة
            ->when($this->year, function ($query) {
                $query->whereYear('created_at', $this->year);
            })
            // ⭐ بحث بعدد النجوم (Average)
            ->when(!empty($this->ratings), function ($q) {
                $q->havingRaw(
                    '(ratings_sum_stars / NULLIF(ratings_count,0)) IN (' .
                    implode(',', $this->ratings) .
                    ')'
                );
            })

            // السعر
            ->when($this->minPrice && $this->maxPrice, function ($q) {
                $q->priceBetween($this->minPrice, $this->maxPrice);
            })

            // القسم الأب
            ->when($this->parent_id, function($q) {
                $q->where('parent_id', $this->parent_id);
            })
            ->when(!is_null($this->discountFilter), function($q) {
                if ($this->discountFilter) {
                    $q->whereHas('currentPromotion'); // عندها تخفيض
                } else {
                    $q->whereDoesntHave('currentPromotion'); // ما عندهاش تخفيض
                }
            })

            ->when($this->color_id, function ($q) {
                $q->byMainColor($this->color_id);
            })

            ->when($this->color_id === 'none', function ($q) {
                $q->withoutColors();
            })

            ->when($this->size_id, function ($q) {
                $q->bySize($this->size_id);
            })

            ->with('currentPromotion')
            ->orderBy('id', 'desc')
            ->paginate(12);

        return view('livewire.Clients.products', [
            'products' => $products,
            'years' => $years,
            'sections'   => Sections::parent()->with('subsections')->get(),
            'colors' => Colors::get(),
            'sizes' => Sizes::get()
        ]);
    }
}
