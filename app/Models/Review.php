<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'travel_id',
        'booking_id',
        'cust_name',
        'asal_kota',
        'description',
        'rating',
        'image1',
        'image2',
        'image3',
        'image4',
        'image5',
        'token',
        'expired_at',
        'status',
    ];


    protected $casts = [
        'rating' => 'integer',
        'status' => 'boolean',
        'expired_at' => 'datetime',
    ];


    public function travel(): BelongsTo
    {
        return $this->belongsTo(
            Travel::class,
            'travel_id'
        );
    }
}
