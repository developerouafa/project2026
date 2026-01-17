<?php

namespace App\Livewire\Dashboardumc\Merchants\Products;

use App\Models\Product;
use App\Models\Sections;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class createproductnocolor extends Component
{
    use WithFileUploads;

    public $name;
    public $description;
    public $image;
    public $status = 1;
    public $section_id;
    public $parent_id;
    public $merchant_id;
    public $quantity;
    public $price;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpg,jpeg,png',
        'status' => 'required|boolean',
        'quantity' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
    ];

    public function save()
    {
        $data = $this->validate();
        if ($this->image) {
            $data['image'] = $this->image->store('products', 'public');
        }

        $data['in_stock'] = $this->quantity > 0 ? 1 : 0;

        Product::create($data);

        session()->flash('success', 'تم إضافة المنتج بنجاح');

        $this->reset();
        $this->status = 1;
    }

    public function render()
    {
        $childrens = Sections::latest()->selectchildrens()->withchildrens()->child()->get();
        $sections = Sections::latest()->selectsections()->withsections()->parent()->get();
        return view('livewire.Dashboardumc.merchants.products.createproductnocolor', [
            'sections' => $sections,
            'childrens' => $childrens
        ]);
    }

}
