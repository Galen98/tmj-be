<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ParameterGlobals\ParameterGlobalService;
use Illuminate\Http\JsonResponse;

class ParameterGlobalController extends Controller
{
    public function __construct(
        private ParameterGlobalService $service
    ) {
    }

    public function show(string $name): JsonResponse
    {
        $parameter = $this->service->getPublicByName($name);

        if (!$parameter) {
            return response()->json([
                'success' => false,
                'message' => 'Parameter tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'name' => $parameter->name,
                'value' => $parameter->value,
            ],
        ]);
    }
}
