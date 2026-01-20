<?php

namespace Database\Seeders;

use App\Models\Promotions;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromotionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Promotions::create([
            'price'       => 99.99,
            'product_id'  => 1, // تأكدي أن المنتج موجود
            'merchant_id' => 1, // تأكدي أن التاجر موجود
            'start_time'  => Carbon::now(),
            'end_time'    => Carbon::now()->addDays(10),
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        Promotions::create([
            'price'       => 149.50,
            'product_id'  => 2,
            'merchant_id' => 1,
            'start_time'  => Carbon::now()->subDays(20),
            'end_time'    => Carbon::now()->subDays(5),
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    }
}
