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
        Schema::create('travel_addons', function (Blueprint $table) {
    $table->id();

    $table->foreignId('travel_option_id')
        ->constrained('travel_options')
        ->cascadeOnDelete();

    $table->string('addon_name', 150);
    $table->string('description', 500)->nullable();

    $table->decimal('price', 15, 2);

    $table->unsignedInteger('min')->default(0);
    $table->unsignedInteger('max')->default(1);

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
