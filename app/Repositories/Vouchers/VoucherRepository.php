<?php

namespace App\Repositories\Vouchers;

use App\Models\Voucher;
use Illuminate\Database\Eloquent\Collection;

class VoucherRepository
{
    public function getAll(): Collection
    {
        return Voucher::query()
            ->latest()
            ->get();
    }


    public function getAvailableForFrontend(): Collection
    {
        return Voucher::query()

            ->where('status', true)

            ->where(
                'is_visible',
                true
            )

            ->where(
                'voucher_expired',
                '>',
                now()
            )

            ->whereColumn(
                'claim',
                '<',
                'quota'
            )

            ->orderBy(
                'voucher_expired'
            )

            ->get();
    }


    public function findById(
        int $id
    ): ?Voucher {
        return Voucher::find($id);
    }


    public function create(
        array $data
    ): Voucher {
        return Voucher::create(
            $data
        );
    }


    public function update(
        Voucher $voucher,
        array $data
    ): Voucher {
        $voucher->update(
            $data
        );

        return $voucher->refresh();
    }


    public function delete(
        Voucher $voucher
    ): bool {
        return $voucher->delete();
    }
}
