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
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'customer_name')) {
                $table->string('customer_name')->default('Guest')->after('court_id');
            }
            if (!Schema::hasColumn('bookings', 'customer_email')) {
                $table->string('customer_email')->default('guest@example.com')->after('customer_name');
            }
            if (!Schema::hasColumn('bookings', 'customer_phone')) {
                $table->string('customer_phone')->default('-')->after('customer_email');
            }
            if (!Schema::hasColumn('bookings', 'players')) {
                $table->unsignedTinyInteger('players')->default(4)->after('customer_phone');
            }
            if (!Schema::hasColumn('bookings', 'notes')) {
                $table->text('notes')->nullable()->after('players');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['customer_name', 'customer_email', 'customer_phone', 'players', 'notes']);
        });
    }
};
