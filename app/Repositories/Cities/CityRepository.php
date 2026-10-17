<?php

namespace App\Repositories\Cities;

use App\Models\City;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CityRepository
{
    public function getAll(): Collection
    {
        return City::query()
            ->latest()
            ->get();
    }

    public function getAllActive(): Collection
    {
        return City::query()
            ->where('status', true)
            ->orderBy('name')
            ->get();
    }

    public function findById(
        int $id
    ): ?City {
        return City::find($id);
    }

    public function findBySlug(
        string $slug
    ): ?City {
        return City::query()
            ->where('slug', $slug)
            ->where('status', true)
            ->first();
    }

    public function create(
        array $data
    ): City {
        return City::create($data);
    }

    public function update(
        City $city,
        array $data
    ): City {
        $city->update($data);

        return $city->refresh();
    }

    public function delete(
        City $city
    ): bool {
        return $city->delete();
    }

    public function getCityRating(int $cityId): object
    {
        return DB::table('reviews')
            ->join(
                'travels',
                'reviews.travel_id',
                '=',
                'travels.id'
            )
            ->where('travels.cities_id', $cityId)
            ->selectRaw('
                COALESCE(AVG(reviews.rating), 0) as rating,
                COUNT(reviews.id) as total_reviews
            ')
            ->first();
    }
}
