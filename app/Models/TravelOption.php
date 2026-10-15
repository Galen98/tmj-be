<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\TravelOptionPrice;

class TravelOption extends Model
{
    protected $fillable = [
        'travel_id',
        'option_name',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function travel(): BelongsTo
    {
        return $this->belongsTo(Travel::class);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(
            TravelOptionPrice::class
        );
    }

    public function times(): HasMany
    {
        return $this->hasMany(
            TravelOptionTime::class
        );
    }

    public function addons(): HasMany
    {
        return $this->hasMany(
            TravelAddon::class
        );
    }

    public function dateAvailabilities(): HasMany
    {
        return $this->hasMany(DateAvailability::class);
    }
}
