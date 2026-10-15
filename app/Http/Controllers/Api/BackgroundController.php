<?php

namespace App\Http\Controllers\Api;

use App\DTO\Backgrounds\BackgroundDTO;
use App\Http\Controllers\Controller;
use App\Services\Backgrounds\BackgroundService;

class BackgroundController extends Controller
{
    public function __construct(
        protected BackgroundService $service
    ) {
    }


    public function index()
    {
        $backgrounds =
            $this->service
                ->getActiveForFrontend();


        $data =
            $backgrounds
                ->map(
                    fn ($background) =>
                        BackgroundDTO::fromModel(
                            $background
                        )->toArray()
                )
                ->values();


        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
