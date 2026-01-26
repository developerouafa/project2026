<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Packageproducts;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $carts = Cart::all();
        $products = Product::all();
        $packages = Packageproducts::all();

        foreach ($carts as $cart) {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $products->random()->id,
                'package_product_id' => $packages->random()->id,
                'color' => 'Red',
                'size' => 'M',
                'qty' => rand(1,5),
                'price' => rand(50,200),
                'status' => 'active',
            ]);
        }
    }
}
