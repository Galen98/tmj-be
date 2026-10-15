<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserTokens\UserTokenService;
use Illuminate\Http\JsonResponse;

class UserTokenController extends Controller
{
    public function __construct(
        private UserTokenService $service
    ) {
    }


    public function store(): JsonResponse
    {
        return response()->json([
            'success' => true,

            'data' =>
                $this->service->create(),
        ], 201);
    }
}
