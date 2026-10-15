<?php

namespace App\Repositories\DateAvailabilities;

use App\Models\DateAvailability;
use App\Models\Travel;
use App\Models\TravelOption;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class DateAvailabilityRepository
{
    public function getTravels(?string $search = null): LengthAwarePaginator
    {
        return Travel::query()
            ->withCount('options')
            ->when(
                filled($search),
                fn ($query) => $query->where(
                    'travel_name',
                    'like',
                    '%' . $search . '%'
                )
            )
            ->orderBy('travel_name')
            ->paginate(10)
            ->withQueryString();
    }

    public function getOptions(Travel $travel): Collection
    {
        return $travel->options()
            ->withCount('dateAvailabilities')
            ->get();
    }

    public function getDates(TravelOption $option): LengthAwarePaginator
    {
        return $option->dateAvailabilities()
            ->orderBy('date', 'desc')
            ->paginate(15)
            ->withQueryString();
    }

    public function create(array $data): DateAvailability
    {
        return DateAvailability::create($data);
    }

    public function update(
        DateAvailability $availability,
        array $data
    ): DateAvailability {
        $availability->update($data);

        return $availability->refresh();
    }

    public function delete(DateAvailability $availability): bool
    {
        return (bool) $availability->delete();
    }

    public function getByTravelOptionId(int $travelOptionId): Collection
    {
        return DateAvailability::query()
            ->where('travel_option_id', $travelOptionId)
            ->orderBy('date', 'asc')
            ->get([
                'id',
                'travel_option_id',
                'date',
                'status',
            ]);
    }
}
