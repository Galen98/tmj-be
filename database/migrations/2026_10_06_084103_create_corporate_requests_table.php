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
       Schema::create('corporate_requests', function (Blueprint $table) {
            $table->id();

            $table->string('company_name');
            $table->string('whatsapp', 30);
            $table->string('email');

            $table->unsignedInteger('duration_days');
            $table->unsignedInteger('participant_count');

            $table->boolean('include_hotel')->default(false);

            $table->string('departure_location');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corporate_requests');
    }
};
