<?php

namespace App\Http\Controllers\Api;

use App\DTO\Vouchers\VoucherDTO;
use App\Http\Controllers\Controller;
use App\Services\Vouchers\VoucherService;

class VoucherController extends Controller
{
    public function __construct(
        protected VoucherService $service
    ) {
    }


    public function index()
    {
        $vouchers =
            $this->service
                ->getAvailableForFrontend();


        $data =
            $vouchers
                ->map(
                    fn ($voucher) =>
                        VoucherDTO::fromModel(
                            $voucher
                        )->toArray()
                )
                ->values();


        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
