<?php

namespace App\Livewire\clients;

use App\Models\Colors;
use App\Models\Product;
use App\Models\Sections;
use App\Models\Sizes;
use Livewire\Component;
use Livewire\WithPagination;

class products extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '', $year = '',
    $ratings = [],
    $parent_id,
    $minPrice,
    $maxPrice,
    $hasColor = null,
    $discountFilter = null,
    $color_id,
    $size_id;

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
