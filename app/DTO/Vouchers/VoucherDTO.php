<?php

namespace App\DTO\Vouchers;

use App\DTO\BaseDTO;
use App\Models\Voucher;

class VoucherDTO extends BaseDTO
{
    public function __construct(
        public int $id,
        public string $voucherName,
        public string $voucherCode,
        public string $voucherExpired,
        public int $quota,
        public int $claim,
        public string $discountType,
        public float $discountValue,
        public ?float $maxDiscount,
        public float $minTransaction,
    ) {
    }

    public static function fromModel(
        Voucher $voucher
    ): self {
        return new self(
            id: $voucher->id,

            voucherName:
                $voucher->voucher_name,

            voucherCode:
                $voucher->voucher_code,

            voucherExpired:
                $voucher->voucher_expired
                    ->toISOString(),

            quota:
                $voucher->quota,

            claim:
                $voucher->claim,

            discountType:
                $voucher->discount_type,

            discountValue:
                (float) $voucher->discount_value,

            maxDiscount:
                $voucher->max_discount !== null
                    ? (float) $voucher->max_discount
                    : null,

            minTransaction:
                (float) $voucher->min_transaction,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,

            'voucherName' =>
                $this->voucherName,

            'voucherCode' =>
                $this->voucherCode,

            'voucherExpired' =>
                $this->voucherExpired,

            'quota' =>
                $this->quota,

            'claim' =>
                $this->claim,

            'remainingQuota' =>
                max(
                    0,
                    $this->quota - $this->claim
                ),

            'discountType' =>
                $this->discountType,

            'discountValue' =>
                $this->discountValue,

            'maxDiscount' =>
                $this->maxDiscount,

            'minTransaction' =>
                $this->minTransaction,
        ];
    }
}
