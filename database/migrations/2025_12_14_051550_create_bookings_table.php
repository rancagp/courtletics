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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('court_id')->constrained('courts')->onDelete('cascade');

            // Personal Information (booking bisa untuk orang lain)
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->text('notes')->nullable();

            $table->enum('status', ['Pending', 'Confirmed', 'Cancelled', 'Completed'])->default('Pending');
            $table->date('booking_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->decimal('total_price', 12, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
