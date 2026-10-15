<?php

namespace App\Http\Requests\Vouchers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVoucherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'voucher_name' => [
                'required',
                'string',
                'max:150',
            ],

            'voucher_code' => [
                'required',
                'string',
                'max:50',

                Rule::unique(
                    'vouchers',
                    'voucher_code'
                )->ignore(
                    $this->route('voucher')
                ),
            ],

            'voucher_expired' => [
                'required',
                'date',
            ],

            'quota' => [
                'required',
                'integer',
                'min:1',
            ],

            'claim' => [
                'required',
                'integer',
                'min:0',
            ],

            'discount_type' => [
                'required',
                Rule::in([
                    'percentage',
                    'fixed',
                ]),
            ],

            'discount_value' => [
                'required',
                'numeric',
                'min:0',
            ],

            'max_discount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'min_transaction' => [
                'required',
                'numeric',
                'min:0',
            ],

            'is_visible' => [
                'nullable',
                'boolean',
            ],

            'status' => [
                'nullable',
                'boolean',
            ],
        ];
    }
}
