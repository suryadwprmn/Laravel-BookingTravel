<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    
  public function run(): 
  void{
    $permissions = ['manage categories','manage packages','manage transactions','manage package banks','checkout package','view orders',];

        foreach($permissions as $permission){
            Permission::firstOrCreate([
                'name' => $permission
            ]);
        }

        $customerRole = Role::firstOrCreate([
            'name' => 'customer'
        ]);

        $customerPermissions = [
            'checkout package',
            'view orders'
        ];

        $customerRole->syncPermissions($customerPermissions);

        $superAdminRole = Role::firstOrCreate([
            'name' => 'super_admin'
        ]);

        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'super3@admin.com',
            'phone_number' => '6283943989212',
            'avatar' => 'images/default-avatar.png',
            'password' => bcrypt('123123123')
        ]);
        $user->assignRole($superAdminRole);


    }
}