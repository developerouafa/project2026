<?php

namespace Database\Seeders;

use App\Models\color_variants;
use App\Models\Product_colors;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorVariantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $productColors = Product_colors::all();

        foreach ($productColors as $pc) {

            // تحقق واش عندنا لون مرتبط
            $colorName = $pc->color ? $pc->color->name : 'Default Color';
            $colorCode = $pc->color ? $pc->color->code : '#' . dechex(rand(0x000000, 0xFFFFFF));

            for ($i = 1; $i <= 2; $i++) {
                Color_variants::create([
                    'name'             => $colorName . ' Variant ' . $i,
                    'code'             => $colorCode,
                    'product_color_id' => $pc->id,
                ]);
            }
        }
    }
}
