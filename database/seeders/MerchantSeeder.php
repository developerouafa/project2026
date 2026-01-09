<?php

namespace Database\Seeders;

use App\Models\Merchant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //* create Merchant
        $merchant = Merchant::create([
            'name' => ['en' => 'merchant', 'ar' => 'تاجر'],
            'phone' => '0682201021',
            'email' => 'merchant@gmail.com',
            'password' => Hash::make('12345678'),
        ]);


        //* Create Role Permissions
        $role = Role::create(['name' => 'owner', 'guard_name' => 'merchants']);

        // Get all permissions of web guard
        $permissions = Permission::where('guard_name','merchants')->get();

        // Attach permissions to role
        $role->syncPermissions($permissions);

        // Assign role to user
        $merchant->assignRole($role);   // ✅ NOT ID
    }
}
