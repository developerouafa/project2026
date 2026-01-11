<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Product_color_sizes;
use App\Models\Product_colors;
use App\Models\Sizes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductColorSizesSeeder extends Seeder
{
    public function run(): void
    {
        $colors = Product_colors::all();
        $sizes = Sizes::all();

        foreach ($colors as $color) {
            foreach ($sizes as $size) {
                Product_color_sizes::create([
                    'product_color_id' => $color->id,
                    'size_id' => $size->id,
                    'quantity' => rand(0, 50),
                    'price' => rand(50, 500), // سعر عشوائي
                    'in_stock' => rand(0,1),
                    'sku' => 'SKU-' . strtoupper(substr($color->name,0,3)) . '-' . $size->id,
                ]);
            }
        }
    }
}
