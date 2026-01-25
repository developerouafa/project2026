<?php

namespace Database\Seeders;

use App\Models\Addresse;
use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressSeeder extends Seeder
{
     public function run(): void
    {
        $clients = Client::all();

        foreach ($clients as $client) {

            // 🔹 عنوان افتراضي
            Addresse::create([
                'client_id'   => $client->id,
                'title'       => 'المنزل',
                'street'      => 'شارع السلام 123',
                'city'        => 'الرباط',
                'state'       => 'الرباط سلا القنيطرة',
                'postal_code' => '10000',
                'country'     => 'Morocco',
                'phone'       => '+212600000000',
                'default'     => true,
            ]);

            // 🔹 عنوان إضافي
            Addresse::create([
                'client_id'   => $client->id,
                'title'       => 'العمل',
                'street'      => 'شارع محمد الخامس 45',
                'city'        => 'الدار البيضاء',
                'state'       => 'الدار البيضاء سطات',
                'postal_code' => '20000',
                'country'     => 'Morocco',
                'phone'       => '+212600000001',
                'default'     => false,
            ]);

            // 🔹 عنوان إضافي عشوائي
            Addresse::create([
                'client_id'   => $client->id,
                'title'       => 'آخر',
                'street'      => 'شارع الحسن الثاني 78',
                'city'        => 'مراكش',
                'state'       => 'مراكش آسفي',
                'postal_code' => '40000',
                'country'     => 'Morocco',
                'phone'       => '+212600000002',
                'default'     => false,
            ]);
        }
    }
}
