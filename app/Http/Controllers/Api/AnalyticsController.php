<?php

namespace App\Http\Controllers\Api;

use App\DTO\Analytics\AnalyticsDTO;
use App\Http\Controllers\Controller;
use App\Services\Analytics\AnalyticsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function __construct(
        private AnalyticsService $service
    ) {
    }


    public function store(
        Request $request
    ): JsonResponse {

        /*
         * =========================================
         * VALIDATE
         * =========================================
         */

        $validated =
            $request->validate([
                'path' => [
                    'required',
                    'string',
                    'max:500',
                    'starts_with:/',
                ],

                'travel_id' => [
                    'nullable',
                    'integer',
                    'exists:travels,id',
                ],
            ]);


        /*
         * =========================================
         * DTO
         * =========================================
         */

        $dto =
            new AnalyticsDTO(
                path:
                    $validated['path'],

                travelId:
                    $validated['travel_id'] ?? null
            );


        /*
         * =========================================
         * TRACK
         * =========================================
         */

        $this->service->track(
            $dto,
            $request
        );


        /*
         * =========================================
         * RESPONSE
         * =========================================
         */

        return response()->json([
            'success' => true,
        ]);
    }
}
