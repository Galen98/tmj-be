<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('date_availabilities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('travel_option_id')
                ->constrained('travel_options')
                ->cascadeOnDelete();

            $table->date('date');

            $table->boolean('status')->default(true);

            $table->timestamps();

            $table->unique(
                ['travel_option_id', 'date'],
                'date_availability_option_date_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('date_availabilities');
    }
};
