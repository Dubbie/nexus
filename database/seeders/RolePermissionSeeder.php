<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    const ROLES = [
        'developer',
        'admin',
        'broker',
        'customer'
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createRoles();
        $this->createPermissions();
    }

    private function createPermissions()
    {
        $permissions = [
            'edit clients',
            'delete clients',
            'view clients'
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }

        // Attach permissions to the developer role
        $developer = Role::where('name', 'developer')->first();
        $developer->givePermissionTo($permissions);

        // Assign role to the developer account
        $user = User::where('email', config('dev.email'))->first();
        $user->assignRole('developer');
    }

    private function createRoles()
    {
        foreach (self::ROLES as $role) {
            Role::create([
                'name' => $role
            ]);
        }
    }
}
