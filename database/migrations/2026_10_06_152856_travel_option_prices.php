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
        Schema::create('travel_option_prices', function (Blueprint $table) {
    $table->id();

    $table->foreignId('travel_option_id')
        ->constrained('travel_options')
        ->cascadeOnDelete();

    $table->string('type', 20);
    $table->string('label', 100);

    $table->unsignedInteger('min');
    $table->unsignedInteger('max')->nullable();

    $table->decimal('price', 15, 2);

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
