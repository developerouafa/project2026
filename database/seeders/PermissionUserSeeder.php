<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            //! Dashboard Users
            'Header Page Dashboard',
            'Content Page Dashboard',

            //! Users
            'sidebar users & permissions',
            'sidebar users',
            'sidebar Deleted users',
            'Create User',
            'Show users',
            'Show users softdelete',
            'Edit User',
            'Delete User',
            'Delete All Users softdelete',
            'Delete All Users',
            'Delete Group Users',
            'Delete Group Users softdelete',
            'Restore One User',
            'Restore Group Users',
            'Restore All Users',
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
