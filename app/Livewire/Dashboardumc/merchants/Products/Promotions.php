<?php

namespace App\Livewire\Dashboardumc\merchants\Products;

use App\Models\Product;
use App\Models\Promotions as ModelsPromotions;
use Livewire\Component;
use App\Models\Sizes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Promotions extends Component
{
    public $promotions, $Products, $promotion_id, $price, $product_id, $merchant_id, $start_time, $end_time;

    public function render()
    {
        $this->promotions = ModelsPromotions::latest()->get();
        $this->Products = Product::latest()->get();
         return view('livewire.Dashboardumc.merchants.Promotions.promotions');
    }

    public function store()
    {
        $this->validate([
            'price' => ['required', 'numeric', 'min:1'],

            'product_id' => [
                'required',
                'exists:products,id',
            ],

            'start_time' => [
                'required',
                'date',
            ],

            'end_time' => [
                'required',
                'date',
                'after_or_equal:start_time',
            ],
        ], [
            'price.required' => 'Price is required',
            'price.numeric'  => 'Price must be a number',
            'price.min'      => 'Price must be greater than 0',

            'product_id.required' => 'Product is required',
            'product_id.exists'   => 'Selected product does not exist',

            'start_time.required' => 'Start date is required',
            'start_time.date'     => 'Start date is not valid',

            'end_time.required' => 'End date is required',
            'end_time.date'     => 'End date is not valid',
            'end_time.after_or_equal' => 'End date must be after start date',
        ]);

        try{
            DB::beginTransaction();
                ModelsPromotions::Create(
                    [
                        'price' => $this->price,
                        'product_id' => $this->product_id,
                        'merchant_id' => Auth::guard('merchants')->id(),
                        'start_time' => $this->start_time,
                        'end_time' => $this->end_time
                    ]
                );
            DB::commit();
                session()->flash('success','Saved successfully');
                return redirect()->route('dashboard.promotions');
        }
        catch(\Exception $exception){
            DB::rollBack();
            session()->flash('error', 'An error');
            return redirect()->to('dashboard.promotions');
        }
    }

    public function update($promotion_id)
    {
        ModelsPromotions::findOrFail($promotion_id)->update([
            'price'      => $this->price,
            'start_time' => $this->start_time,
            'end_time'   => $this->end_time,
        ]);

        session()->flash('success', 'Update Successfully');
        return redirect()->route('dashboard.promotions');
    }

    public function delete($id)
    {
        ModelsPromotions::findOrFail($id)->delete();
        session()->flash('success','Deleted successfully');
        return redirect()->route('dashboard.promotions');
    }
}
