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
    Schema::create('courts', function (Blueprint $table) {
        $table->id();
        // Relasi ke court_categories
        $table->foreignId('court_category_id')->constrained('court_categories')->onDelete('cascade');
        $table->string('court_name');
        $table->string('location');
        $table->decimal('price_per_hour', 10, 2); // Pakai decimal untuk uang
        $table->text('description')->nullable();
        $table->boolean('is_available')->default(true);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courts');
    }
};
