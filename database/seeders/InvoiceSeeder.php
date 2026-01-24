<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $orders = Order::all();

        foreach ($orders as $order) {
            Invoice::create([
                'invoice_number' => 'INV-' . rand(1000,9999),
                'order_id' => $order->id,
                'merchant_id' => $order->merchant_id,
                'client_id' => $order->client_id,
                'subtotal' => $order->total,
                'tax' => $order->total * 0.2,
                'total' => $order->total * 1.2,
                'status' => 'draft',
            ]);
        }
    }
}
