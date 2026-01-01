<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('bookings')->insert([
            'user_id' => 2,
            'court_id' => 1,

            'customer_name' => 'John Doe',
            'customer_email' => 'johndoe@example.com',
            'customer_phone' => '081234567890',
            'players' => 4,
            'notes' => 'Booking untuk latihan',

            'status' => 'Confirmed',
            'booking_date' => '2025-12-30',
            'start_time' => '14:00:00',
            'end_time' => '16:00:00',
            'total_price' => 300000, 

            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
