<?php

namespace App\Services\DateAvailabilities;

use App\Models\DateAvailability;
use App\Models\Travel;
use App\Models\TravelOption;
use App\Repositories\DateAvailabilities\DateAvailabilityRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DateAvailabilityService
{
    public function __construct(
        private DateAvailabilityRepository $repository
    ) {}

    public function getTravels(?string $search = null): LengthAwarePaginator
    {
        return $this->repository->getTravels($search);
    }

    public function getOptions(Travel $travel): Collection
    {
        return $this->repository->getOptions($travel);
    }

    public function getDates(TravelOption $option): LengthAwarePaginator
    {
        return $this->repository->getDates($option);
    }

    public function create(TravelOption $option, array $data): DateAvailability
    {
        $validated = Validator::make($data, [
            'date' => [
                'required',
                'date_format:Y-m-d',
                Rule::unique('date_availabilities', 'date')
                    ->where('travel_option_id', $option->id),
            ],
            'status' => ['required', 'boolean'],
        ])->validate();

        return $this->repository->create([
            'travel_option_id' => $option->id,
            'date' => $validated['date'],
            'status' => $validated['status'],
        ]);
    }

    public function update(
        DateAvailability $availability,
        array $data
    ): DateAvailability {
        $validated = Validator::make($data, [
            'date' => [
                'required',
                'date_format:Y-m-d',
                Rule::unique('date_availabilities', 'date')
                    ->where('travel_option_id', $availability->travel_option_id)
                    ->ignore($availability->id),
            ],
            'status' => ['required', 'boolean'],
        ])->validate();

        return $this->repository->update($availability, $validated);
    }

    public function delete(DateAvailability $availability): bool
    {
        return $this->repository->delete($availability);
    }

    public function getByTravelOptionId(int $travelOptionId): array
    {
        return $this->repository
            ->getByTravelOptionId($travelOptionId)
            ->map(function ($availability) {
                return [
                    'id' => $availability->id,
                    'travel_option_id' => $availability->travel_option_id,
                    'date' => $availability->date->format('Y-m-d'),
                    'status' => (bool) $availability->status,
                ];
            })
            ->values()
            ->all();
    }
}
