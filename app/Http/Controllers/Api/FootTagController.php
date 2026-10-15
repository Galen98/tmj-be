<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FootTags\FootTagService;
use Illuminate\Http\JsonResponse;

class FootTagController extends Controller
{
    public function __construct(
        private FootTagService $service
    ) {
    }


    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,

            'data' =>
                $this->service->getAll(),
        ]);
    }
}
