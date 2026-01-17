<?php

namespace App\Livewire\Dashboardumc\Merchants\Products;

use App\Models\Product;
use Livewire\Component;

class productindex extends Component
{
    public $search = '';

    protected $queryString = ['search'];

    public function delete($id)
    {
        Product::findOrFail($id)->delete();
    }

    public function render()
    {
        $products = Product::latest()
            ->selectBasic()
            ->byMerchant(auth()->guard('merchants')->user()->id)
            ->get();

         return view('livewire.Dashboardumc.merchants.products.productindex', [
            'products' => $products
        ]);


    }

}
