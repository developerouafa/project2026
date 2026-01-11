<?php

namespace Database\Seeders;

use App\Models\Color_variant_sizes;
use App\Models\color_variants;
use App\Models\Sizes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorVariantSizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $variants = color_variants::all();
        $sizes    = Sizes::all();

        foreach ($variants as $variant) {
            // لكل فاريانت نربط 2-3 أحجام عشوائية
            $assignedSizes = $sizes->random(min(3, $sizes->count()));

            foreach ($assignedSizes as $size) {
                Color_variant_sizes::create([
                    'color_variant_id' => $variant->id,
                    'size_id'          => $size->id,
                    'quantity'         => rand(5, 50),
                    'price'            => rand(100, 200),
                    'in_stock'         => 1,
                    'sku'              => 'SKU-'.$variant->id.'-'.$size->id,
                ]);
            }
        }
    }
}
