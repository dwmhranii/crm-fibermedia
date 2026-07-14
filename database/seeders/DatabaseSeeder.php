<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AdminUserSeeder::class,

            SiteSettingSeeder::class,
            CoverageSeeder::class,
            FaqSeeder::class,
            PackageSeeder::class,
            WhyCardSeeder::class,
            PageSeeder::class,
        ]);
    }
}
