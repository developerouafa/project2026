<?php

namespace App\Livewire\Dashboardumc\Merchants\Products;

use App\Models\Product;
use App\Models\Sections;
use App\Traits\UploadImageTraitt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class createproductnocolor extends Component
{
    use WithFileUploads, UploadImageTraitt;

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
        try{
            $data = $this->validate();

                if ($this->image) {
                    $data['image'] = $this->uploadImagePRnocolor($this->image, 'productnocolorimage');
                }


                $data['in_stock'] = $this->quantity > 0 ? 1 : 0;

            DB::beginTransaction();
                $data['merchant_id'] = Auth::guard('merchants')->id();
                $sectionid = Sections::findOrFail($this->parent_id);
                $data['parent_id'] = $sectionid->id;
                $data['section_id'] = $sectionid->parent_id;
                Product::create($data);

                session()->flash('success', 'Create successfully');

                $this->reset();
                $this->status = 1;

            DB::commit();
                return redirect()->route('dashboard.products');
        }
        catch(\Exception $exception){
            DB::rollBack();
            session()->flash('error', 'An error occurred while saving');
            return redirect()->route('dashboard.products');
        }
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
