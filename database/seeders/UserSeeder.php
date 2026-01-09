<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //* create User
        $user = User::create([
            'name' => ['en' => 'ouafa', 'ar' => 'وفاء'],
            'phone' => '0682201020',
            'email' => 'ProjectTree@gmail.com',
            'password' => Hash::make('2026target'),
        ]);
    }
}
