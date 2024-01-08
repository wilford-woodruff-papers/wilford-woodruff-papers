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
        Schema::table('presses', function (Blueprint $table) {
            $table->date('day_in_the_life_date')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presses', function (Blueprint $table) {
            $table->dropColumn('day_in_the_life_date');
        });
    }
};
