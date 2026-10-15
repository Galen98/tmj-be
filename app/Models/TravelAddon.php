<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TravelAddon extends Model
{
    protected $fillable = [
        'travel_option_id',
        'addon_name',
        'description',
        'price',
        'min',
        'max',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
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
