<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TravelOption;
use App\Services\DateAvailabilities\DateAvailabilityService;
use Illuminate\Http\JsonResponse;

class DateAvailabilityController extends Controller
{
    public function __construct(
        private DateAvailabilityService $service
    ) {}

    public function index(TravelOption $option): JsonResponse
    {
        $availabilities = $this->service
            ->getByTravelOptionId($option->id);

        return response()->json([
            'success' => true,
            'data' => $availabilities,
        ]);
    }
}
