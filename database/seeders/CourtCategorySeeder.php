<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourtCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Indoor' => 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?w=400',
            'Outdoor' => 'https://images.unsplash.com/photo-1622163642998-1ea32b0bbc67?w=400',
            'Semi Outdoor' => 'https://images.unsplash.com/photo-1622279457486-62dcc4a431d6?w=400',
        ];

        foreach ($categories as $cat => $image) {
            DB::table('court_categories')->insert([
                'category_name' => $cat,
                'description' => 'Deskripsi untuk lapangan ' . $cat,
                'image' => $image,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}