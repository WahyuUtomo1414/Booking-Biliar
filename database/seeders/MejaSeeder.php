<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MejaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mejas = [];

        // 1–15 Regular
        for ($i = 1; $i <= 15; $i++) {
            $mejas[] = [
                'nama' => 'Meja ' . $i,
                'tipe' => 'Regular',
                'harga_per_jam' => 70000,
                'status' => 'Tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // 16–20 VIP
        for ($i = 16; $i <= 20; $i++) {
            $mejas[] = [
                'nama' => 'Meja ' . $i,
                'tipe' => 'VIP',
                'harga_per_jam' => 95000,
                'status' => 'Tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('meja')->insert($mejas);
    
    }
}
