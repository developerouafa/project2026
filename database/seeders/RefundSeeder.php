<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Merchant;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Refund;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RefundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::all();
        $merchants = Merchant::all();
        $payments = Payment::all();
        $clients = Client::all();

        foreach ($orders as $order) {
            // نعمل بعض العمليات العشوائية للـ refund
            if (rand(0, 1)) { // 50% فرصة يكون refund
                Refund::create([
                    'order_id' => $order->id,
                    'merchant_id' => $merchants->random()->id,
                    'payment_id' => $payments->random()->id,
                    'client_id' => $order->client_id,
                    'amount' => rand(50, intval($order->total)), // قيمة ال refund أقل أو مساوية للـ total
                    'reason' => 'Customer request',
                    'status' => 'processed', // أو pending, rejected
                    'processed_at' => now(),
                ]);
            }
        }
    }
}
