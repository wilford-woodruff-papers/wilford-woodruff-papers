<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->date('pid_identified_at')->nullable();
            $table->date('bio_approved_at')->nullable();
            $table->date('place_confirmed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn('pid_identified_at');
            $table->dropColumn('bio_approved_at');
            $table->dropColumn('place_confirmed_at');
        });
    }
};
