<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analytics', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_token_id')
                ->nullable()
                ->constrained('user_tokens')
                ->nullOnDelete();

            $table->string('ip_address', 45)
                ->nullable();

            $table->bigInteger('travel_id')
                ->nullable();

            $table->string('path', 500);

            $table->string('country', 100)
                ->nullable();

            $table->string('province', 100)
                ->nullable();

            $table->text('user_agent')
                ->nullable();

            $table->timestamps();

            $table->index('path');
            $table->index('created_at');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('analytics');
    }
};
