<?php

namespace App\Livewire\Dashboardumc\Merchants\Products;

use App\Models\Product;
use App\Models\Sections;
use App\Traits\UploadImageTraitt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Component;

class productindex extends Component
{
        use WithFileUploads, UploadImageTraitt;

    public $search = '';
    public $product_id;
    public $name;
    public $description;
    public $price;
    public $quantity;
    public $status;
    public $parent_id;
    public $sections;
    public $childrens;
    public $image;
    public $isOpen = false;

    protected $queryString = ['search'];

    public function delete($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $product = Product::findOrFail($id);

                // حذف الصورة من storage
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }

                // حذف المنتج
                $product->delete();
            });
            session()->flash('success', 'Deleted successfully');
            return redirect()->route('dashboard.products');

        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting');
            return redirect()->route('dashboard.products');
        }

        // try{
        //     DB::beginTransaction();
        //         product::findOrFail($id)->delete();
        //     DB::commit();
        //     session()->flash('success', 'Deleted successfully');
        //     // $this->dispatch('$refresh');
        //     return redirect()->to('dashboard.products');
        // }
        // catch(\Exception $exception){
        //     DB::rollBack();
        //     session()->flash('error', 'An error occurred while deleting');
        //     // $this->dispatch('$refresh');
        //     return redirect()->to('dashboard.products');
        // }
    }

    public function createproductnocolor(){
        return redirect()->route('dashboard.createproductnocolor');
    }

    // فتح الفورم للإضافة
    public function openCreateModal()
    {
        $this->resetForm();
        $this->isOpen = true;
    }

    public function resetForm()
    {
        $this->reset(['product_id','name','description','price','quantity','status']);
    }

    public function editproductnocolor($id){
        $product = Product::findOrFail($id);

        $this->product_id  = $product->id;
        $this->name        = $product->name;
        $this->description = $product->description;
        $this->price       = $product->price;
        $this->quantity    = $product->quantity;
        $this->status      = $product->status;
        $this->parent_id   = $product->parent_id;
        $this->image   = $product->image;

        $this->isOpen = true; // فتح Modal

        $this->dispatch('open-modal', id: 'add_products');
    }

    public function updateProduct()
    {
        $this->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'quantity'    => 'required|integer',
            'status'      => 'required|boolean',
            'parent_id'   => 'required|exists:sections,id',
        ]);

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($this->product_id);

            // رفع صورة جديدة إذا تم اختيارها
            if ($this->image) {
                $product->image = $this->uploadImagePRnocolor($this->image, 'productnocolorimage');
            }

            $product->name        = $this->name;
            $product->description = $this->description;
            $product->price       = $this->price;
            $product->quantity    = $this->quantity;
            $product->in_stock    = $this->quantity > 0 ? 1 : 0;
            $product->status      = $this->status;

            $product->save();

            DB::commit();

            session()->flash('success', 'تم تعديل المنتج بنجاح');
            return redirect()->route('dashboard.products');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'حدث خطأ أثناء التعديل');
            return redirect()->route('dashboard.products');
        }
    }

    public function render()
    {
        $products = Product::latest()
            ->selectBasic()
            ->byMerchant(Auth::guard('merchants')->id())
            ->get();

         return view('livewire.Dashboardumc.merchants.products.productindex', [
            'products' => $products
        ]);
    }

}
