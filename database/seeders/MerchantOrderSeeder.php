<?php

namespace Database\Seeders;

use App\Models\Merchant;
use App\Models\MerchantOrder;
use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MerchantOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $orders = Order::all();
        $merchants = Merchant::all();

        foreach ($orders as $order) {
            MerchantOrder::create([
                'order_id' => $order->id,
                'merchant_id' => $merchants->random()->id,
                'status' => 'pending',
                'accepted_at' => null,
            ]);
        }
    }
}
