<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = Client::all();

        foreach ($clients as $client) {
            Payment::create([
                'date' => now(),
                'client_id' => $client->id,
                'amount' => rand(100, 1000),
                'method' => 'cash',
                'reference' => 'PAY-' . rand(1000, 9999),
                'description' => 'Payment for order',
            ]);
        }
        foreach ($clients as $client) {
            Payment::create([
                'date' => now(),
                'client_id' => $client->id,
                'amount' => rand(100, 1000),
                'method' => 'bank_transfer',
                'reference' => 'PAY-' . rand(1000, 9999),
                'description' => 'Payment for order',
            ]);
        }
    }
}
