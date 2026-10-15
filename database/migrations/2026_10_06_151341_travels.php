<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('travels', function (Blueprint $table) {
            $table->id();

            $table->string('travel_name', 200);
            $table->string('slug', 200)->unique();

            $table->string('short_description', 500);
            $table->text('full_description');

            $table->foreignId('cities_id')
                ->constrained('cities')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('point_of_interest_id')
                ->nullable()
                ->constrained('point_of_interests')
                ->nullOnDelete();

            $table->unsignedInteger('duration');
            $table->string('duration_type', 20);
            $table->unsignedInteger('duration_hours');

            $table->boolean('is_pickup')->default(false);
            $table->string('pickup_venue', 255)->nullable();

            $table->boolean('is_corporate')->default(false);
            $table->boolean('is_group')->default(false);
            $table->unsignedInteger('jumlah_peserta')->nullable();
            $table->boolean('is_children')->default(false);

            $table->boolean('is_discount')->default(false);

            $table->decimal('price_now', 15, 2);
            $table->decimal('price_discount', 15, 2)->nullable();

            $table->string('image1', 500);
            $table->string('image2', 500)->nullable();
            $table->string('image3', 500)->nullable();
            $table->string('image4', 500)->nullable();
            $table->string('image5', 500)->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
