<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TravelOptionTime extends Model
{
    protected $fillable = [
        'travel_option_id',
        'time',
        'is_active',
        'status',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'status' => 'boolean',
    ];

    public function option(): BelongsTo
    {
        return $this->belongsTo(
            TravelOption::class,
            'travel_option_id'
        );
    }
}
