<?php

namespace Database\Seeders;

use App\Models\Sizes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
   {
        $sizes = [

            // 👕 Clothes (International)
            ['name' => 'XS', 'description' => 'Extra Small'],
            ['name' => 'S',  'description' => 'Small'],
            ['name' => 'M',  'description' => 'Medium'],
            ['name' => 'L',  'description' => 'Large'],
            ['name' => 'XL', 'description' => 'Extra Large'],
            ['name' => 'XXL','description' => 'Double Extra Large'],
            ['name' => 'XXXL','description' => 'Triple Extra Large'],

            // 👖 Jeans / Pants
            ['name' => '28', 'description' => 'Waist 28'],
            ['name' => '30', 'description' => 'Waist 30'],
            ['name' => '32', 'description' => 'Waist 32'],
            ['name' => '34', 'description' => 'Waist 34'],
            ['name' => '36', 'description' => 'Waist 36'],
            ['name' => '38', 'description' => 'Waist 38'],

            // 👟 Shoes (EU)
            ['name' => '36', 'description' => 'EU 36'],
            ['name' => '37', 'description' => 'EU 37'],
            ['name' => '38', 'description' => 'EU 38'],
            ['name' => '39', 'description' => 'EU 39'],
            ['name' => '40', 'description' => 'EU 40'],
            ['name' => '41', 'description' => 'EU 41'],
            ['name' => '42', 'description' => 'EU 42'],
            ['name' => '43', 'description' => 'EU 43'],
            ['name' => '44', 'description' => 'EU 44'],
            ['name' => '45', 'description' => 'EU 45'],
        ];

        foreach ($sizes as $size) {
            Sizes::firstOrCreate(
                ['name' => $size['name']],
                ['description' => $size['description']]
            );
        }
    }
}
