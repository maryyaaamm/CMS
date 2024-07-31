<?php
// database/seeders/RolePermissionSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create Roles
        $superadmin = Role::create(['name' => 'superadmin']);
        $user = Role::create(['name' => 'user']);

        // Define Permissions
        $permissions = [
            'create post',
            'edit post',
            'delete post',
            'approve post',
            'view post',
            'comment on post',
            'like post',
        ];

        // Create Permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign Permissions to Roles
        $superadmin->givePermissionTo('approve post');
        $user->givePermissionTo([
            'create post',
            'edit post',
            'delete post',
            'view post',
            'comment on post',
            'like post',
        ]);
    }
}
