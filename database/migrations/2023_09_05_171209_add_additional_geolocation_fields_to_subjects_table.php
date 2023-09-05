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
        Schema::table('subjects', function (Blueprint $table) {
            $table->after('geolocation', function (Blueprint $table) {
                $table->boolean('is_partial')
                    ->default(false);
                $table->string('google_map_address')
                    ->nullable();
                $table->string('google_map_id')
                    ->nullable();
                $table->json('northeast_box')
                    ->nullable();
                $table->json('southwest_box')
                    ->nullable();
                $table->dateTime('geolocation_updated_at')
                    ->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn([
                'is_partial',
                'google_map_address',
                'google_map_id',
                'northeast_box',
                'southwest_box',
                'geolocation_updated_at',
            ]);
        });
    }
};
