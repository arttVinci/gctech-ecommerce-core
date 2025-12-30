<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $role = Role::firstOrCreate(
            ['name' => 'super_admin', 'guard_name' => 'web']
        );

        $this->call([
            // RegionSeeder::class,
            ProductSeeder::class
        ]);

        $user = User::factory()->create([
            'name' => 'Admin Ganteng',
            'email' => 'admin@email.test',
            'password' => bcrypt('password123'),
        ]);

        $user->assignRole($role);
    }
}
