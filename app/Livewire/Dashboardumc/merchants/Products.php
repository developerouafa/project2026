<?php

namespace App\Livewire\Dashboardumc\merchants;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Products extends Component
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
            ->byMerchant(Auth::guard('merchants')->id())
            ->searchByName($this->search)
            ->recentlyAdded()
            ->paginate(10);

         return view('livewire.Dashboardumc.merchants.products', [
            'products' => $products
        ]);
    }


}
