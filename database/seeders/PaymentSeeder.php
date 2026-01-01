<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        // Pembayaran untuk Booking ID 1
        DB::table('payments')->insert([
            'booking_id' => 1,
            'payment_method' => 'Transfer Bank',
            'payment_status' => 'completed',
            'amount' => 300000,
            'payment_date' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}