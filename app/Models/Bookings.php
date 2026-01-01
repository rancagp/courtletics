<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bookings extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'court_id',

        // Personal Info
        'customer_name',
        'customer_email',
        'customer_phone',

        // Booking detail
        'booking_date',
        'start_time',
        'end_time',
        'total_price',
        'status',
        'midtrans_order_id',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    /**
     * Relasi ke user (nullable untuk guest booking)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke court
     */
    public function court(): BelongsTo
    {
        return $this->belongsTo(Courts::class);
    }

    /**
     * Relasi ke payment
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payments::class);
    }
}
