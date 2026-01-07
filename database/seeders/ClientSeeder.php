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
    }
}
