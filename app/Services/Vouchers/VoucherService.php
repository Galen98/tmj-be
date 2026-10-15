<?php

namespace App\Services\Vouchers;

use App\Models\Voucher;
use App\Repositories\Vouchers\VoucherRepository;
use Illuminate\Database\Eloquent\Collection;

class VoucherService
{
    public function __construct(
        protected VoucherRepository $repository
    ) {
    }


    public function getAll(): Collection
    {
        return $this->repository
            ->getAll();
    }


    public function getAvailableForFrontend(): Collection
    {
        return $this->repository
            ->getAvailableForFrontend();
    }


    public function findById(
        int $id
    ): Voucher {
        $voucher =
            $this->repository
                ->findById($id);

        abort_if(
            !$voucher,
            404,
            'Voucher tidak ditemukan.'
        );

        return $voucher;
    }


    public function create(
        array $data
    ): Voucher {

        $data['voucher_code'] =
            strtoupper(
                trim(
                    $data['voucher_code']
                )
            );

        $data['claim'] =
            $data['claim'] ?? 0;

        $data['is_visible'] =
            $data['is_visible'] ?? false;

        $data['status'] =
            $data['status'] ?? false;


        /*
         * Fixed discount tidak membutuhkan
         * max discount.
         */

        if (
            $data['discount_type']
            === 'fixed'
        ) {
            $data['max_discount'] =
                null;
        }


        return $this->repository
            ->create($data);
    }


    public function update(
        Voucher $voucher,
        array $data
    ): Voucher {

        $data['voucher_code'] =
            strtoupper(
                trim(
                    $data['voucher_code']
                )
            );

        $data['is_visible'] =
            $data['is_visible'] ?? false;

        $data['status'] =
            $data['status'] ?? false;


        if (
            $data['discount_type']
            === 'fixed'
        ) {
            $data['max_discount'] =
                null;
        }


        return $this->repository
            ->update(
                $voucher,
                $data
            );
    }


    public function delete(
        Voucher $voucher
    ): bool {
        return $this->repository
            ->delete($voucher);
    }
}
