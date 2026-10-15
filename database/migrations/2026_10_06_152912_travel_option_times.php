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
        Schema::create('travel_option_times', function (Blueprint $table) {
    $table->id();

    $table->foreignId('travel_option_id')
        ->constrained('travel_options')
        ->cascadeOnDelete();

    $table->time('time');

    $table->boolean('is_active')->default(true);
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
