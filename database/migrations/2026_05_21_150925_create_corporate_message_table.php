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
        Schema::create('corporate_message', function (Blueprint $table) {
            $table->id();
            $table->string('corporate_name');
            $table->string('corporate_contact');
            $table->integer('hari_acara');
            $table->integer('jumlah_peserta');
            $table->boolean('add_hotel')->default(false);
            $table->string('lokasi_start');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corporate_message');
    }
};
