<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Shipping;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = Client::all();
        $invoices = Invoice::all();
        $payments = Payment::all();

        foreach ($clients as $client) {
            Shipping::create([
                'date' => now(),
                'client_id' => $client->id,
                'invoice_id' => $invoices->random()->id,
                'payment_id' => $payments->random()->id,
                'debit' => rand(50, 200),
                'credit' => rand(0, 50),
                'source' => 'delivery',
            ]);
        }
    }
}
