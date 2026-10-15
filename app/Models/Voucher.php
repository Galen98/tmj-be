<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucher_name',
        'voucher_code',
        'voucher_expired',
        'quota',
        'claim',
        'discount_type',
        'discount_value',
        'max_discount',
        'min_transaction',
        'is_visible',
        'status',
    ];

    protected $casts = [
        'voucher_expired' => 'datetime',

        'quota' => 'integer',
        'claim' => 'integer',

        'discount_value' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'min_transaction' => 'decimal:2',

        'is_visible' => 'boolean',
        'status' => 'boolean',
    ];
}
