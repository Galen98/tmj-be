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
        Schema::create('travel_options', function (Blueprint $table) {
    $table->id();

    $table->foreignId('travel_id')
        ->constrained('travels')
        ->cascadeOnDelete();

    $table->string('option_name', 200);
    $table->text('description')->nullable();

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
