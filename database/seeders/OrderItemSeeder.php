<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Packageproducts;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $orders = Order::all();
        $products = Product::all();
        $packages = Packageproducts::all();

        foreach ($orders as $order) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $products->random()->id,
                'package_product_id' => $packages->random()->id,
                'color' => 'Blue',
                'size' => 'L',
                'qty' => rand(1,3),
                'price' => rand(50,300),
            ]);
        }
    }
}
