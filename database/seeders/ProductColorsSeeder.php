<?php

namespace Database\Seeders;

use App\Models\Colors;
use App\Models\Product;
use App\Models\Product_colors;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Color;

class ProductColorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $products = Product::all();
        $colors   = Colors::all();

        foreach ($products as $product) {
            // لكل منتج نربط 2-3 ألوان عشوائية
            $assignedColors = $colors->random(min(3, $colors->count()));

            foreach ($assignedColors as $color) {
                Product_colors::create([
                    'product_id'   => $product->id,
                    'color_id'     => $color->id,
                    'has_variants' => rand(0,1), // عشوائي: variant أو لا
                ]);
            }
        }
    }
}
