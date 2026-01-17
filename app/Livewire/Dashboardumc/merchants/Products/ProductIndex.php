<?php

namespace App\Livewire\Dashboardumc\Merchants\Products;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class productindex extends Component
{
    public $search = '';

    protected $queryString = ['search'];

    public function delete($id)
    {
        try {
            DB::transaction(function () use ($id) {
                Product::findOrFail($id)->delete();
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
