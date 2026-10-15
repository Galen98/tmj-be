<?php

namespace App\Http\Controllers\Api;

use App\DTO\PointOfInterests\PointOfInterestDTO;
use App\Http\Controllers\Controller;
use App\Services\PointOfInterests\PointOfInterestService;

class PointOfInterestController extends Controller
{
    public function __construct(
        protected PointOfInterestService $service
    ) {
    }

    public function index()
    {
        $pointOfInterests =
            $this->service
                ->getAllActive();

        $data =
            $pointOfInterests
                ->map(
                    fn ($pointOfInterest) =>
                        PointOfInterestDTO::fromModel(
                            $pointOfInterest
                        )->toArray()
                )
                ->values();

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function show(
        string $slug
    ) {
        $pointOfInterest =
            $this->service
                ->findBySlug($slug);

        return response()->json([
            'success' => true,

            'data' =>
                PointOfInterestDTO::fromModel(
                    $pointOfInterest
                )->toArray(),
        ]);
    }
}
