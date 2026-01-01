<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,           // 0. Table Role
            UserSeeder::class,           // 1. Table Users
            CourtCategorySeeder::class,  // 2. Table Kategori Lapangan
            CourtSeeder::class,          // 3. Table Lapangan
            CourtImageSeeder::class,     // 4. Table Gambar Lapangan
            BookingSeeder::class,        // 5. Table Booking
            PaymentSeeder::class,        // 6. Table Pembayaran
        ]);
    }
}