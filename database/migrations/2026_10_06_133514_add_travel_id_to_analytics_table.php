<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(
            'analytics',
            function (Blueprint $table) {

                $table
                    ->unsignedBigInteger('travel_id')
                    ->nullable()
                    ->after('user_token_id');

                $table
                    ->foreign('travel_id')
                    ->references('id')
                    ->on('travels')
                    ->nullOnDelete();
            }
        );
    }


    public function down(): void
    {
        Schema::table(
            'analytics',
            function (Blueprint $table) {

                $table->dropForeign([
                    'travel_id',
                ]);

                $table->dropColumn(
                    'travel_id'
                );
            }
        );
    }
};
