<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Region\RegionService;
use Illuminate\Http\JsonResponse;
use Throwable;

class RegionController extends Controller
{
    public function __construct(
        private RegionService $regionService
    ) {
    }


    public function provinces(): JsonResponse
    {
        try {

            $data =
                $this->regionService
                    ->getProvinces();

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);

        } catch (Throwable $e) {

            report($e);

            return response()->json([
                'success' => false,
                'message' =>
                    'Gagal mengambil data provinsi.',
            ], 500);
        }
    }


    public function regencies(
        string $provinceCode
    ): JsonResponse {
        try {

            $data =
                $this->regionService
                    ->getRegencies(
                        $provinceCode
                    );

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);

        } catch (Throwable $e) {

            report($e);

            return response()->json([
                'success' => false,
                'message' =>
                    'Gagal mengambil data kota/kabupaten.',
            ], 500);
        }
    }
}
