<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //* create Client
        Client::create([
            'name' => ['en' => 'client', 'ar' => 'عميل'],
            'phone' => '0682201021',
            'email' => 'client@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        Client::create([
            'name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'can_login' => true,
            'account_state' => 'active',
        ]);
    }
}
