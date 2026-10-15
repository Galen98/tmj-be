<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DateAvailability extends Model
{
    protected $fillable = [
        'travel_option_id',
        'date',
        'status',
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'status' => 'boolean',
    ];

    public function travelOption(): BelongsTo
    {
        return $this->belongsTo(TravelOption::class);
    }
}
