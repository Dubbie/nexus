<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create the developer
        $this->createDeveloper();

        // Call rest of the seeders
        $this->call([
            RolePermissionSeeder::class,
            InsurerSeeder::class
        ]);
    }

    private function createDeveloper()
    {
        User::factory()->create([
            'name' => config('dev.name'),
            'email' => config('dev.email'),
            'password' => Hash::make(config('dev.password')),
        ]);
    }
}
