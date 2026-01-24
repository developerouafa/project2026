<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Client;
use App\Models\Merchant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $clients = Client::all();
        $merchants = Merchant::all();

        foreach ($clients as $client) {
            Cart::create([
                'client_id' => $client->id,
                'merchant_id' => $merchants->random()->id,
                'status' => 'active',
            ]);
        }
    }
}
