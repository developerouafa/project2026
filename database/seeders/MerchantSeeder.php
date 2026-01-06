<?php

namespace Database\Seeders;

use App\Models\Merchant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //* create Merchant
        Merchant::create([
            'name' => ['en' => 'merchant', 'ar' => 'تاجر'],
            'phone' => '0682201021',
            'email' => 'merchant@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
