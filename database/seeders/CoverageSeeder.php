<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoverageSeeder extends Seeder
{
    public function run(): void
    {
        $areas = [
            'Wandanpuro','Bululawang','Krebet','Senggrong','Lumbangsari',
            'Gading','Karang Jambe','Sempalwadak','Tambakasri',
            'Kendalpayak','Segenggeng','Arjowinangun','Tlogowaru',
            'Wonokoyo','Gadang'
        ];

        foreach ($areas as $area) {
            DB::table('coverages')->insert([
                'name' => $area,
                'city' => 'Malang',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
