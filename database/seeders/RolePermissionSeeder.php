<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $permissions = [
            'manage categories',
            'manage packages',
            'manage transactions',
            'manage package banks',
            'checkout package',
            'view orders'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission]
            );
        }
        
        $customerRole = Role::firstOrCreate(
            ['name' => 'customer']
        );

        $customerPermissions = [
            'checkout package',
            'view orders'
        ];
        //mengizinkan permission ke role customer
        $customerRole->syncPermissions($customerPermissions);

        $superAdminRole = Role::firstOrCreate(
            ['name' => 'super_admin']
        );

        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'super@admin.com',
            'phone_number' => '081234567890',
            'avatar' => 'images/default-avatar.png',
            'password' => bcrypt('rahasia'),
            ]
        );

        $user->assignRole($superAdminRole);
    }
}
