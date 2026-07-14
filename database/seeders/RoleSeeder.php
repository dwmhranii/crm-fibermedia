<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::updateOrCreate(['slug' => 'superadmin'], [
            'name' => 'Super Admin',
            'description' => 'Full akses semua menu',
            'is_active' => 1,
        ]);

        Role::updateOrCreate(['slug' => 'admin'], [
            'name' => 'Admin',
            'description' => 'Kelola konten & leads',
            'is_active' => 1,
        ]);
    }
}
