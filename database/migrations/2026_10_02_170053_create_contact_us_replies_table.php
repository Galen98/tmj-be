<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'contact_us_replies',
            function (Blueprint $table) {

                $table->id();

                $table->foreignId(
                    'contact_us_id'
                )
                    ->constrained(
                        'contact_us'
                    )
                    ->cascadeOnDelete();

                $table->text(
                    'message'
                );

                $table->timestamp(
                    'sent_at'
                )->nullable();

                $table->timestamps();
            }
        );
    }


    public function down(): void
    {
        Schema::dropIfExists(
            'contact_us_replies'
        );
    }
};
