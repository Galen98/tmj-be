<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Travel extends Model
{
    protected $table = 'travels';
    protected $fillable = [
        'travel_name',
        'slug',
        'short_description',
        'full_description',
        'cities_id',
        'point_of_interest_id',

        'duration',
        'duration_type',
        'duration_hours',

        'is_pickup',
        'pickup_venue',

        'is_corporate',
        'is_group',
        'jumlah_peserta',
        'is_children',

        'is_discount',
        'price_now',
        'price_discount',

        'image1',
        'image2',
        'image3',
        'image4',
        'image5',

        'status',
    ];

    protected $casts = [
        'is_pickup' => 'boolean',
        'is_corporate' => 'boolean',
        'is_group' => 'boolean',
        'is_children' => 'boolean',
        'is_discount' => 'boolean',
        'status' => 'boolean',

        'price_now' => 'decimal:2',
        'price_discount' => 'decimal:2',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(
            City::class,
            'cities_id'
        );
    }

    public function pointOfInterest(): BelongsTo
    {
        return $this->belongsTo(
            PointOfInterest::class,
            'point_of_interest_id'
        );
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            'travel_tags',
            'travel_id',
            'tags_id'
        );
    }

    public function includes(): HasMany
    {
        return $this->hasMany(TravelInclude::class)
            ->orderBy('sort_order');
    }

    public function options(): HasMany
    {
        return $this->hasMany(TravelOption::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(
            Review::class,
            'travel_id',
            'id'
        );
    }

    public function activeReviews(): HasMany
    {
        return $this->hasMany(
            Review::class,
            'travel_id',
            'id'
        )->where('status', true);
    }
}
