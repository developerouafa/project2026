<?php

namespace App\Livewire\Dashboardumc\merchants;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductIndex extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = ['search'];

    public function delete($id)
    {
        Product::findOrFail($id)->delete();
    }

    public function render()
    {
        $products = Product::parent()
            ->selectBasic()
            ->searchByName($this->search)
            ->recentlyAdded()
            ->paginate(10);

        return view('livewire.Dashboardumc.merchants.index', [
            'products' => $products
        ]);
    }
}
