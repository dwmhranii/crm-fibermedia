<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('site_settings')->insert([
            [
                'key' => 'site_name',
                'value' => 'Fibermedia Linktel',
                'group' => 'general',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'contact_whatsapp',
                'value' => '+62xxxxxxxxxxx',
                'group' => 'contact',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@domain.com',
                'group' => 'contact',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

