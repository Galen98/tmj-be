<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TravelDetailResource;
use App\Http\Resources\TravelResource;
use App\Services\Travel\TravelService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TravelController extends Controller
{
    public function __construct(
        private TravelService $travelService
    ) {
    }

    /*
    |--------------------------------------------------------------------------
    | List
    |--------------------------------------------------------------------------
    */

    public function index(
        Request $request
    ): AnonymousResourceCollection {

        $validated = $request->validate([
            'search' => [
                'nullable',
                'string',
                'max:200',
            ],

            'city' => [
                'nullable',
                'string',
                'max:200',
            ],

            'poi' => [
                'nullable',
                'string',
                'max:200',
            ],

            'tag' => [
                'nullable',
                'string',
                'max:200',
            ],

            'sort' => [
                'nullable',
                'in:most-popular,lowest-price,highest-price,shortest-duration,longest-duration,duration_asc,duration_desc,price_asc,price_desc',
            ],

            'per_page' => [
                'nullable',
                'integer',
                'min:1',
                'max:50',
            ],

            'is_corporate' => [
                'nullable',
                'boolean',
            ],
        ]);
        $isCorporate = $request->boolean('is_corporate');
        $travels = $this->travelService
            ->getPublicTravels(
                perPage: $validated['per_page'] ?? 12,
                search: $validated['search'] ?? null,
                citySlug: $validated['city'] ?? null,
                poiSlug: $validated['poi'] ?? null,
                tagSlug: $validated['tag'] ?? null,
                sort: $validated['sort'] ?? null,
                isCorporate: $isCorporate
            );

        return TravelResource::collection($travels);
    }

    /*
    |--------------------------------------------------------------------------
    | Detail
    |--------------------------------------------------------------------------
    */

    public function show(
        string $slug
    ): TravelDetailResource {
        $travel =
            $this->travelService
                ->getPublicDetail(
                    $slug
                );

        return new TravelDetailResource(
            $travel
        );
    }
}
