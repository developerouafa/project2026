<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Merchant;
use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $clients = Client::all();
        $merchants = Merchant::all();

        foreach ($clients as $client) {
            Order::create([
                'client_id' => $client->id,
                'merchant_id' => $merchants->random()->id,
                'total' => rand(100,1000),
                'status' => 'pending',
            ]);
        }
    }
}
