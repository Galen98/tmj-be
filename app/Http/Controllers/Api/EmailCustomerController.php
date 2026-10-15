<?php

namespace App\Http\Controllers\Api;

use App\DTO\EmailCustomers\EmailCustomerDTO;
use App\Http\Controllers\Controller;
use App\Services\EmailCustomers\EmailCustomerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmailCustomerController extends Controller
{
    public function __construct(
        private EmailCustomerService $service
    ) {
    }


    public function store(
        Request $request
    ): JsonResponse {

        $validated =
            $request->validate([
                'email' => [
                    'required',
                    'email',
                    'max:255',
                ],
            ]);


        $dto =
            new EmailCustomerDTO(
                strtolower(
                    trim(
                        $validated['email']
                    )
                )
            );


        $result =
            $this->service
                ->subscribe(
                    $dto
                );


        if (
            $result['alreadySubscribed']
        ) {

            return response()->json([
                'success' => true,

                'message' =>
                    'Email Anda sudah terdaftar sebagai pelanggan Travel Murah Jogja.',
            ]);
        }


        return response()->json([
            'success' => true,

            'message' =>
                'Terima kasih telah berlangganan Travel Murah Jogja.',
        ], 201);
    }
}