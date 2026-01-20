<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\rating;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ratingseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // جيب جميع المنتجات
        $products = Product::all();

        foreach ($products as $product) {
            // عدد التقييمات لكل منتج (مثلاً من 1 حتى 5)
            $ratingsCount = rand(1, 5);

            for ($i = 0; $i < $ratingsCount; $i++) {
                rating::create([
                    'stars'       => rand(1, 5),
                    'comment'     => fake()->sentence(),
                    'product_id'  => $product->id,
                    'client_id' => '1',
                ]);
            }
        }
    }
}
