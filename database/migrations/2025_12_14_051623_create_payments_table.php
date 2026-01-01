<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
        $table->string('payment_method'); // Transfer, E-wallet, dll
        $table->string('payment_status'); // Paid, Unpaid
        $table->dateTime('payment_date')->nullable();
        $table->decimal('amount', 12, 2);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
