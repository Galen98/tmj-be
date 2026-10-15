<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {

            $table->id();

            /*
             * =========================================
             * RELATION
             * =========================================
             */

            $table->foreignId('travel_id')
                ->constrained('travels')
                ->cascadeOnDelete();


            /*
             * Nanti digunakan ketika review
             * berasal dari booking customer.
             *
             * Untuk review dari admin = NULL.
             *
             * FK booking belum dipasang dulu
             * supaya tidak bergantung pada
             * struktur tabel booking sekarang.
             */

            $table->unsignedBigInteger(
                'booking_id'
            )->nullable();


            /*
             * =========================================
             * CUSTOMER
             * =========================================
             */

            $table->string(
                'cust_name',
                150
            );

            $table->string(
                'asal_kota',
                150
            )->nullable();


            /*
             * =========================================
             * REVIEW
             * =========================================
             */

            $table->text(
                'description'
            )->nullable();

            $table->unsignedTinyInteger(
                'rating'
            );


            /*
             * =========================================
             * IMAGES
             * =========================================
             */

            $table->string(
                'image1',
                500
            )->nullable();

            $table->string(
                'image2',
                500
            )->nullable();

            $table->string(
                'image3',
                500
            )->nullable();

            $table->string(
                'image4',
                500
            )->nullable();

            $table->string(
                'image5',
                500
            )->nullable();


            /*
             * =========================================
             * CUSTOMER REVIEW TOKEN
             * =========================================
             *
             * Belum digunakan untuk admin.
             * Disiapkan untuk customer review nanti.
             */

            $table->string(
                'token',
                100
            )
                ->nullable()
                ->unique();

            $table->timestamp(
                'expired_at'
            )->nullable();


            /*
             * =========================================
             * STATUS
             * =========================================
             */

            $table->boolean(
                'status'
            )->default(true);


            /*
             * =========================================
             * TIMESTAMP
             * =========================================
             */

            $table->timestamps();


            /*
             * =========================================
             * INDEX
             * =========================================
             */

            $table->index([
                'travel_id',
                'status',
            ]);

            // $table->index(
            //     'booking_id'
            // );
        });
    }


    public function down(): void
    {
        Schema::dropIfExists(
            'reviews'
        );
    }
};
