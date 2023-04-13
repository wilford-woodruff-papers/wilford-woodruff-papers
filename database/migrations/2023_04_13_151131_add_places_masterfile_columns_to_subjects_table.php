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
            $table->string('country')
                ->nullable();
            $table->string('state_province')
                ->nullable();
            $table->string('county')
                ->nullable();
            $table->string('city')
                ->nullable();
            $table->string('specific_place')
                ->nullable();
            $table->string('years')
                ->nullable();
            $table->string('parent_location')
                ->nullable();
            $table->string('modern_location')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn('country');
            $table->dropColumn('state_province');
            $table->dropColumn('county');
            $table->dropColumn('county');
            $table->dropColumn('specific_place');
            $table->dropColumn('years');
            $table->dropColumn('parent_location');
            $table->dropColumn('modern_location');
        });
    }
};
