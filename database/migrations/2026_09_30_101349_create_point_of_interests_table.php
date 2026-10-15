<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'point_of_interests',
            function (Blueprint $table) {

                $table->id();

                $table->foreignId('city_id')
                    ->constrained('cities')
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();

                $table->string('name', 150);

                $table->string('slug', 180)
                    ->unique();

                $table->text('description')
                    ->nullable();

                $table->string('image')
                    ->nullable();

                $table->boolean('status')
                    ->default(true);

                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'point_of_interests'
        );
    }
};
