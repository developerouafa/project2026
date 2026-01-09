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
            'Create User',
            'Show merchants',
            'Show merchants softdelete',
            'Edit User',
            'Delete User',
            'Delete All merchants softdelete',
            'Delete All merchants',
            'Delete Group merchants',
            'Delete Group merchants softdelete',
            'Restore One User',
            'Restore Group merchants',
            'Restore All merchants',
            'Delete One User softdelete',

            //! Permissions
            'sidebar permissions',
            'Create role',
            'Show roles',
            'Modify roles',
            'Delete role',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
