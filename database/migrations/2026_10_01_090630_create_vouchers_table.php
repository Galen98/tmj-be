<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();

            $table->string('voucher_name', 150);

            $table->string('voucher_code', 50)
                ->unique();

            $table->timestamp('voucher_expired');

            $table->unsignedInteger('quota')
                ->default(0);

            $table->unsignedInteger('claim')
                ->default(0);

            $table->string('discount_type', 20);

            $table->decimal(
                'discount_value',
                15,
                2
            );

            $table->decimal(
                'max_discount',
                15,
                2
            )->nullable();

            $table->decimal(
                'min_transaction',
                15,
                2
            )->default(0);

            $table->boolean('is_visible')
                ->default(true);

            $table->boolean('status')
                ->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
