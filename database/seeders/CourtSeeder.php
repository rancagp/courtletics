<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourtSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('courts')->insert([
            [
                'court_category_id' => 1, // Indoor
                'court_name' => 'Lapangan Anggrek (Indoor)',
                'location' => 'Gedung A',
                'price_per_hour' => 150000,
                'description' => 'Lapangan indoor ber-AC dengan lantai standar internasional.',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'court_category_id' => 2, // Outdoor
                'court_name' => 'Lapangan Melati (Outdoor)',
                'location' => 'Area Taman',
                'price_per_hour' => 100000,
                'description' => 'Lapangan outdoor dengan pemandangan asri dan rumput sintetis.',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'court_category_id' => 3, // Semi Outdoor
                'court_name' => 'Lapangan Mawar (Semi Outdoor)',
                'location' => 'Gedung B',
                'price_per_hour' => 200000,
                'description' => 'Lapangan semi-outdoor dengan atap pelindung hujan dan sirkulasi udara alami.',
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}