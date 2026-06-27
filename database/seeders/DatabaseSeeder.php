<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::firstOrCreate([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->createRoles();
        $user->assignRole('super_admin');
    }

    private function createRoles(): array
    {
        return [
            'super_admin' => Role::firstOrCreate(['name' => 'super_admin']),
            'admin' => Role::firstOrCreate(['name' => 'admin']),
            'viewer' => Role::firstOrCreate(['name' => 'viewer']),
        ];
    }
}
