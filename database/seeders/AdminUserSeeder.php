<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $superRole = Role::where('slug', 'superadmin')->firstOrFail();

        User::updateOrCreate(['email' => 'superadmin@local.test'], [
            'name' => 'Superadmin',
            'role_id' => $superRole?->id,     // pastikan roles sudah ke-seed dulu
            'password' => Hash::make('password123'),
            'is_active' => 1,
        ]);
    }
}
