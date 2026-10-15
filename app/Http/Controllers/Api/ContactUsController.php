<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactUsRequest;
use App\Services\ContactUs\ContactUsService;
use Throwable;

class ContactUsController extends Controller
{
    public function __construct(
        private ContactUsService $service
    ) {
    }


    public function store(
        StoreContactUsRequest $request
    ) {

        try {

            $contact =
                $this->service
                    ->create(
                        $request->validated()
                    );


            return response()->json([
                'success' => true,

                'message' =>
                    'Pesan berhasil dikirim.',

                'data' => [
                    'id' =>
                        $contact->id,
                ],
            ], 201);

        } catch (Throwable $e) {

            report($e);


            return response()->json([
                'success' => false,

                'message' =>
                    'Pesan gagal dikirim.',
            ], 500);
        }
    }
}
