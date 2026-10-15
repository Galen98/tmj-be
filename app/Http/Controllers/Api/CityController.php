<?php

namespace App\Http\Controllers\Api;

use App\DTO\Cities\CitiesDTO;
use App\Http\Controllers\Controller;
use App\Services\Cities\CityService;

class CityController extends Controller
{
    public function __construct(
        protected CityService $cityService
    ) {
    }

    public function index()
    {
        $cities =
            $this->cityService
                ->getAllActive();

        $data =
            $cities
                ->map(
                    fn ($city) =>
                        CitiesDTO::fromModel(
                            $city
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
        $city =
            $this->cityService
                ->findBySlug($slug);

        return response()->json([
            'success' => true,

            'data' =>
                CitiesDTO::fromModel(
                    $city
                )->toArray(),
        ]);
    }
}
