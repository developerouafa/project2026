<?php

namespace App\Livewire\Dashboardumc\merchants;

use App\Models\Product;
use Livewire\Component;

class ProductForm extends Component
{
    public $products, $name, $description, $product_id;
    public $isOpen = false;

    public function render()
    {
        $this->products = Product::latest()->get();
         return view('livewire.Dashboardumc.merchants.products');
    }


}
