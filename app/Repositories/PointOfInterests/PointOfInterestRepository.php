<?php

namespace App\Repositories\PointOfInterests;

use App\Models\PointOfInterest;
use Illuminate\Database\Eloquent\Collection;

class PointOfInterestRepository
{
    public function getAll(): Collection
    {
        return PointOfInterest::query()
            ->with('city')
            ->latest()
            ->get();
    }

    public function getAllActive(): Collection
    {
        return PointOfInterest::query()
            ->with('city')
            ->where('status', true)
            ->orderBy('name')
            ->get();
    }

    public function findById(
        int $id
    ): ?PointOfInterest {
        return PointOfInterest::query()
            ->with('city')
            ->find($id);
    }

    public function findBySlug(
        string $slug
    ): ?PointOfInterest {
        return PointOfInterest::query()
            ->with('city')
            ->where('slug', $slug)
            ->where('status', true)
            ->first();
    }

    public function slugExists(
        string $slug,
        ?int $ignoreId = null
    ): bool {
        return PointOfInterest::query()
            ->where('slug', $slug)
            ->when(
                $ignoreId,
                fn ($query) =>
                    $query->where(
                        'id',
                        '!=',
                        $ignoreId
                    )
            )
            ->exists();
    }

    public function create(
        array $data
    ): PointOfInterest {
        return PointOfInterest::create(
            $data
        );
    }

    public function update(
        PointOfInterest $pointOfInterest,
        array $data
    ): PointOfInterest {
        $pointOfInterest->update(
            $data
        );

        return $pointOfInterest
            ->refresh();
    }

    public function delete(
        PointOfInterest $pointOfInterest
    ): bool {
        return $pointOfInterest
            ->delete();
    }
}
