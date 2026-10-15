<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Search\SearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct(
        private SearchService $service
    ) {
    }


    public function suggestions(
        Request $request
    ): JsonResponse {

        /*
         * =========================================
         * VALIDATION
         * =========================================
         */

        $validated =
            $request->validate([
                'keyword' => [
                    'required',
                    'string',
                    'min:2',
                    'max:100',
                ],
            ]);


        /*
         * =========================================
         * SEARCH
         * =========================================
         */

        $data =
            $this->service
                ->suggestions(
                    trim(
                        $validated['keyword']
                    )
                );


        /*
         * =========================================
         * RESPONSE
         * =========================================
         */

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}