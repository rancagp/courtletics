<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourtsImages extends Model
{
    use HasFactory;

    protected $table = 'court_images';

    protected $fillable = [
        'court_id',
        'image_path',
    ];

    public function court(): BelongsTo
    {
        return $this->belongsTo(Courts::class);
    }
}