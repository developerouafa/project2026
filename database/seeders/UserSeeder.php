<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //* create User
        User::create([
            'name' => ['en' => 'ouafa', 'ar' => 'وفاء'],
            'phone' => '0582201021',
            'email' => 'ProjectTree@gmail.com',
            'password' => Hash::make('2026tar@gmail.com')
        ]);
    }
}
