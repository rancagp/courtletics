<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payments extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'payment_method',
        'payment_status',
        'payment_date',
        'amount',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Bookings::class);
    }
}