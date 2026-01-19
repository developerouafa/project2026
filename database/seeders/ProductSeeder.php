<?php

namespace Database\Seeders;

use App\Models\Merchant;
use App\Models\Product;
use App\Models\Sections;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $merchant = Merchant::first();
        $section  = Sections::first();

        if (!$merchant || !$section) {
            return;
        }

        // Product رئيسي
        Product::create([
            'name'        => 'T-shirt DXN',
            'description' => 'High quality cotton T-shirt',
            'status'      => 1,
            'section_id'  => 1,
            'parent_id'   => 2,
            'merchant_id' => $merchant->id,
            'quantity'    => 50,
            'in_stock'    => 1,
            'price'       => 120,
        ]);

        // Variants (Children)
        Product::create([
            'name'        => 'T-shirt DXN - Red',
            'description' => 'Red Color',
            'status'      => 1,
            'section_id'  => 5,
            'parent_id'   => 4,
            'merchant_id' => $merchant->id,
            'quantity'    => 20,
            'in_stock'    => 1,
            'price'       => 130,
        ]);

        Product::create([
            'name'        => 'T-shirt DXN - Blue',
            'description' => 'Blue Color',
            'status'      => 1,
            'section_id'  => 1,
            'parent_id'   => 6,
            'merchant_id' => $merchant->id,
            'quantity'    => 15,
            'in_stock'    => 1,
            'price'       => 130,
        ]);

        Product::create([
            'name'        => 'T-shirt tiktok - Blue',
            'description' => 'Blue Color',
            'status'      => 1,
            'section_id'  => 1,
            'parent_id'   => 8,
            'merchant_id' => $merchant->id,
        ]);

        Product::create([
            'name'        => 'T-shirt fb - Blue',
            'description' => 'Blue Color',
            'status'      => 1,
            'section_id'  => 3,
            'parent_id'   => 10,
            'merchant_id' => $merchant->id,
        ]);
    }
}
