<?php
// database/seeders/UserSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create roles (if not already created)
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'], // Ensure email is unique
            [
                'name' => 'Admin User',
                'password' => bcrypt('12345678'), // Set password for superadmin
            ]
        );
        $admin->assignRole($superadminRole);

    }
}
