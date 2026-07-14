<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('faqs')->insert([
            [
                'question' => 'Apa itu PT Fibermedia Linktel Akses Indonesia?',
                'answer' => 'PT Fibermedia Linktel Akses Indonesia adalah ISP berbasis fiber optik.',
                'category' => 'Umum',
                'sort_order' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

