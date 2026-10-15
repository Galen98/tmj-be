<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100);

            $table->string('slug', 100)
                ->unique();

            /*
             * Bukan class FontAwesome.
             *
             * Contoh:
             * tags
             * hotel
             * percent
             * building
             */
            $table->string('icon', 50)
                ->nullable();

            $table->boolean('status')
                ->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
