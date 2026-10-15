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
        Schema::create('travel_tags', function (Blueprint $table) {
    $table->id();

    $table->foreignId('travel_id')
        ->constrained('travels')
        ->cascadeOnDelete();

    $table->foreignId('tags_id')
        ->constrained('tags')
        ->cascadeOnDelete();

    $table->unique([
        'travel_id',
        'tags_id',
    ]);
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
