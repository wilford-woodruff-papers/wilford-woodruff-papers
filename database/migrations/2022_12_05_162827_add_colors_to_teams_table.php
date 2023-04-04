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
        Schema::table('teams', function (Blueprint $table) {
            $table->string('background_color')->nullable();
            $table->string('text_color')->nullable();
        });

        Schema::table('board_members', function (Blueprint $table) {
            $table->string('supporting_image')->nullable();
            $table->string('supporting_image_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('background_color');
            $table->dropColumn('text_color');
        });

        Schema::table('board_members', function (Blueprint $table) {
            $table->dropColumn('supporting_image');
            $table->dropColumn('supporting_image_description');
        });
    }
};
