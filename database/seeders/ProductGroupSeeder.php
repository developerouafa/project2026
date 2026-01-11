<?php

namespace Database\Seeders;

use App\Models\Packageproducts;
use App\Models\Product;
use App\Models\Product_Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductGroupSeeder extends Seeder
{
    public function run()
    {
        $packages = Packageproducts::all();
        $products = Product::all();

        if ($packages->isEmpty() || $products->isEmpty()) {
            return; // إذا ماكانش باكيجات أو منتجات، نخرج
        }

        foreach ($packages as $package) {
            // لكل باكيج نربط 2-4 منتجات عشوائية
            $assignedProducts = $products->random(min(4, $products->count()));

            foreach ($assignedProducts as $product) {
                Product_Group::create([
                    'packageproduct_id' => $package->id,
                    'product_id'        => $product->id,
                    'quantity'          => rand(1, 5),
                    'totalprice'        => rand(5, 9), // حساب تقريبي
                ]);
            }
        }
    }
}
