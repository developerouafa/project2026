<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionMerchantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            //! Dashboard merchants
            'Header Page Dashboard',
            'Content Page Dashboard',

            //! merchants
            'sidebar merchants & permissions',
            'sidebar merchants',
            'sidebar Deleted merchants',
            'Create Merchant',
            'Show merchants',
            'Show merchants softdelete',
            'Edit Merchant',
            'Delete Merchant',
            'Delete All merchants softdelete',
            'Delete All merchants',
            'Delete Group merchants',
            'Delete Group merchants softdelete',
            'Restore One Merchant',
            'Restore Group merchants',
            'Restore All merchants',
            'Delete One Merchant softdelete',

            //! Permissions
            'sidebar permissions',
            'Create role',
            'Show roles',
            'Modify roles',
            'Delete role',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'merchant']);
        }
    }
}
