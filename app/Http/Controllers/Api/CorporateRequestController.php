<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendCorporateRequestAdminEmail;
use App\Jobs\SendCorporateRequestCustomerEmail;
use App\Models\CorporateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CorporateRequestController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'company_name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'whatsapp' => [
                    'required',
                    'string',
                    'max:30',
                ],

                'email' => [
                    'required',
                    'email',
                    'max:255',
                ],

                'duration_days' => [
                    'required',
                    'integer',
                    'min:1',
                ],

                'participant_count' => [
                    'required',
                    'integer',
                    'min:1',
                ],

                'include_hotel' => [
                    'required',
                    'boolean',
                ],

                'departure_location' => [
                    'required',
                    'string',
                    'max:255',
                ],
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $corporateRequest =
            CorporateRequest::create(
                $validator->validated()
            );


        /*
         * Email customer
         */

        SendCorporateRequestCustomerEmail::dispatch(
            $corporateRequest->id
        );


        /*
         * Email admin
         */

        SendCorporateRequestAdminEmail::dispatch(
            $corporateRequest->id
        );


        return response()->json([
            'success' => true,
            'message' =>
                'Permintaan paket korporasi berhasil dikirim.',
            'data' => $corporateRequest,
        ], 201);
    }
}
