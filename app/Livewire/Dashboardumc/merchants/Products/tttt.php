<?php

namespace App\Livewire\Dashboardumc\Merchants\Products;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Product;
use App\Models\Sections;
use App\Models\Colors;
use App\Models\Sizes;
use App\Models\Product_colors;
use App\Models\Product_color_sizes;
use App\Models\Multi_image_pr;

use App\Traits\UploadImageTraitt;

class CreateProductsColor extends Component
{
    use WithFileUploads, UploadImageTraitt;

    /* ===== BASIC ===== */
    public $show_table = true;
    public $updateMode = false;
    public $product_id;

    public $name_en, $name_ar;
    public $description_en, $description_ar;
    public $parent_id;
    public $image;

    /* ===== IMAGES ===== */
    public $images = [];

    /* ===== VARIANTS ===== */
    public $has_variants = false;
    public $colors_with_sizes = [];

    /* ===== MOUNT ===== */
    public function mount()
    {
        $this->resetImages();
    }

    private function resetImages()
    {
        $this->images = [[
            'file' => null,
            'path' => null,
            'is_saved' => false,
        ]];
    }

    /* ===== IMAGES ===== */
    public function addImage()
    {
        foreach ($this->images as $img) {
            if (!$img['is_saved']) {
                $this->addError('images', 'حفظ الصورة الحالية أولاً');
                return;
            }
        }

        $this->images[] = [
            'file' => null,
            'path' => null,
            'is_saved' => false,
        ];
    }

    public function saveImage($index)
    {
        $this->validate([
            "images.$index.file" => 'required|image|max:2048',
        ]);

        $path = $this->uploadImagePRnocolor(
            $this->images[$index]['file'],
            'productcolorimage'
        );

        $this->images[$index]['path'] = $path;
        $this->images[$index]['is_saved'] = true;
    }

    public function removeImage($index)
    {
        if (!empty($this->images[$index]['path'])) {
            Storage::disk('public')->delete($this->images[$index]['path']);
        }

        unset($this->images[$index]);
        $this->images = array_values($this->images);

        if (count($this->images) === 0) {
            $this->resetImages();
        }
    }

    /* ===== VARIANTS UI ===== */
    public function toggleVariant($value)
    {
        $this->has_variants = $value;
        $this->colors_with_sizes = [];
    }

    public function addColor()
    {
        $this->colors_with_sizes[] = [
            'color_id' => null,
            'sizes' => [],
        ];
    }

    public function removeColor($index)
    {
        unset($this->colors_with_sizes[$index]);
        $this->colors_with_sizes = array_values($this->colors_with_sizes);
    }

    public function addSize($color_index)
    {
        $this->colors_with_sizes[$color_index]['sizes'][] = [
            'size_id' => null,
            'quantity' => 0,
            'price' => 0,
            'in_stock' => 1,
            'sku' => '',
        ];
    }

    public function removeSize($color_index, $size_index)
    {
        unset($this->colors_with_sizes[$color_index]['sizes'][$size_index]);
        $this->colors_with_sizes[$color_index]['sizes'] =
            array_values($this->colors_with_sizes[$color_index]['sizes']);
    }

    /* ===== SAVE VARIANTS (INTERNAL) ===== */
    protected function saveVariants()
    {
        Product_color_sizes::whereHas('productColor', function ($q) {
            $q->where('product_id', $this->product_id);
        })->delete();

        Product_colors::where('product_id', $this->product_id)->delete();

        foreach ($this->colors_with_sizes as $color) {

            $productColor = Product_colors::create([
                'product_id' => $this->product_id,
                'color_id'   => $color['color_id'],
                'has_variants' => false,
            ]);

            foreach ($color['sizes'] as $size) {
                Product_color_sizes::create([
                    'product_color_id' => $productColor->id,
                    'size_id'  => $size['size_id'],
                    'quantity' => $size['quantity'],
                    'price'    => $size['price'],
                    'in_stock' => $size['in_stock'],
                    'sku'      => $size['sku'],
                ]);
            }
        }
    }

    /* ===== SAVE PRODUCT ===== */
    public function saveProductColor()
    {
        foreach ($this->images as $img) {
            if (!$img['is_saved']) {
                $this->addError('images', 'حفظ جميع الصور أولاً');
                return;
            }
        }

        DB::beginTransaction();

        try {

            if ($this->updateMode) {
                $product = Product::findOrFail($this->product_id);
            } else {
                $product = new Product();
                $product->merchant_id = Auth::guard('merchants')->id();

                $section = Sections::findOrFail($this->parent_id);
                $product->parent_id  = $section->id;
                $product->section_id = $section->parent_id;
                $product->status = 1;
            }

            $product->name = ['en' => $this->name_en, 'ar' => $this->name_ar];
            $product->description = ['en' => $this->description_en, 'ar' => $this->description_ar];

            if ($this->image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                $product->image = $this->uploadImagePRnocolor($this->image, 'products');
            }

            $product->save();
            $this->product_id = $product->id;

            /* VARIANTS */
            $this->saveVariants();

            /* MULTI IMAGES */
            Multi_image_pr::where('product_id', $product->id)->delete();
            foreach ($this->images as $img) {
                Multi_image_pr::create([
                    'product_id' => $product->id,
                    'multi_image' => $img['path'],
                ]);
            }

            DB::commit();

            session()->flash('success', 'تم حفظ المنتج بنجاح');

            $this->reset();
            $this->show_table = true;
            $this->mount();

        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('general', 'حدث خطأ أثناء الحفظ');
        }
    }

    public function show_form_add(){
        $this->reset();
        $this->updateMode = false;
        $this->show_table = false;
        $this->mount();
    }

    /* ================= EDIT ================= */
    public function edit($id)
    {
        $this->show_table = false;
        $this->updateMode = true;

        $product = Product::with(['multiImages','productColors.sizes'])->findOrFail($id);

        $this->product_id = $product->id;
        $this->name_en = $product->getTranslation('name', 'en');
        $this->name_ar = $product->getTranslation('name', 'ar');
        $this->description_en = $product->getTranslation('description', 'en');
        $this->description_ar = $product->getTranslation('description', 'ar');
        $this->image = $product->image;

        $this->images = [];
        foreach ($product->multiImages as $img) {
            $this->images[] = [
                'file' => null,
                'path' => $img->multi_image,
                'is_saved' => true,
                'db_id' => $img->id,
            ];
        }

        $this->colors_with_sizes = [];
        foreach ($product->productColors as $pc) {
            $block = ['color_id' => $pc->color_id, 'sizes' => []];
            foreach ($pc->sizes as $s) {
                $block['sizes'][] = [
                    'size_id' => $s->size_id,
                    'quantity' => $s->quantity,
                    'price' => $s->price,
                    'in_stock' => $s->in_stock,
                    'sku' => $s->sku,
                ];
            }
            $this->colors_with_sizes[] = $block;
        }
    }


    /* ===== RENDER ===== */
    public function render()
    {
        return view('livewire.Dashboardumc.merchants.ProductsColor.create-products-color', [
            'products'   => Product::latest()->get(),
            'sections'   => Sections::parent()->with('subsections')->get(),
            'all_colors' => Colors::all(),
            'all_sizes'  => Sizes::all(),
        ]);
    }
}
