<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Color;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            PermissionUserSeeder::class,
            PermissionMerchantsSeeder::class,
            UserSeeder::class,
            MerchantSeeder::class,
            ClientSeeder::class,
            SectionsSeeder::class,
            SizesSeeder::class,
            ProductSeeder::class,
            ColorSeeder::class,
            ProductColorsSeeder::class,
            ColorVariantsSeeder::class,
            ColorVariantSizesSeeder::class,
            ProductColorSizesSeeder::class,
            PackageproductsSeeder::class,
            ProductGroupSeeder::class,
            PromotionsSeeder::class,
            ratingseeder::class,
            CartSeeder::class,
            CartItemSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
            PaymentSeeder::class,
            MerchantOrderSeeder::class,
            InvoiceSeeder::class,
            ShippingSeeder::class,
            RefundSeeder::class,
        ]);

    }
}
