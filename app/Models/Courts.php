<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Courts extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'court_category_id',
        'court_name',
        'location',
        'price_per_hour',
        'description',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'price_per_hour' => 'decimal:2',
    ];

    public function courtCategory(): BelongsTo
    {
        return $this->belongsTo(CourtCategories::class);
    }
    public function bookings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Bookings::class, 'court_id');
    }

    
    public function images()
    {
        return $this->hasMany(CourtsImages::class, 'court_id');
    }
    
}