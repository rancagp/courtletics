<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourtImageSeeder extends Seeder
{
    public function run(): void
    {
        // Dummy gambar untuk lapangan ID 1, 2, dan 3
        DB::table('court_images')->insert([
            ['court_id' => 1, 'image_path' => 'https://images.unsplash.com/photo-1554068865-24cecd4e34b8?w=800', 'created_at' => now(), 'updated_at' => now()],
            ['court_id' => 2, 'image_path' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=800', 'created_at' => now(), 'updated_at' => now()],
            ['court_id' => 3, 'image_path' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=800', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}