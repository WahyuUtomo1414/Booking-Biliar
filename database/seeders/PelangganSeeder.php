<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pelanggan')->insert([
            [
                'nama' => 'Budi Santoso',
                'nomor_wa' => '6281234567890',
                'email' => 'budi@gmail.com',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Siti Rahmawati',
                'nomor_wa' => '6282233445566',
                'email' => 'siti@gmail.com',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Rizky Maulana',
                'nomor_wa' => '6285712345678',
                'email' => 'rizky@gmail.com',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Dewi Anjani',
                'nomor_wa' => '6283812345678',
                'email' => 'dewi@gmail.com',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Andi Pratama',
                'nomor_wa' => '6287812345678',
                'email' => 'andi@gmail.com',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
