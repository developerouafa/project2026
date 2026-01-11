<?php

namespace Database\Seeders;

use App\Models\Merchant;
use App\Models\Packageproducts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageproductsSeeder extends Seeder
{
    public function run()
    {
        $merchant = Merchant::first();

        if (!$merchant) {
            return; // إذا ماكانش تاجر، نخرج
        }

        // نخلق 3 باكيجات كمثال
        for ($i = 1; $i <= 3; $i++) {
            Packageproducts::create([
                'name'                 => 'Package '.$i,
                'notes'                => 'Notes for package '.$i,
                'Total_before_discount' => rand(100, 500),
                'discount_value'       => rand(5, 50),
                'Total_after_discount' => 0, // غادي نحسبو بعدا
                'tax_rate'             => 15,
                'Total_with_tax'       => 0, // غادي نحسبو بعدا
                'merchant_id'          => $merchant->id,
            ]);
        }

        // تحديث الإجماليات بعد الإدخال
        Packageproducts::all()->each(function($package) {
            $totalAfterDiscount = $package->Total_before_discount - $package->discount_value;
            $package->update([
                'Total_after_discount' => $totalAfterDiscount,
                'Total_with_tax'       => $totalAfterDiscount * 1.15, // tax_rate 15%
            ]);
        });
    }
}
