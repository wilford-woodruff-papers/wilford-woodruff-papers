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
        Schema::table('items', function (Blueprint $table) {
            $table->unsignedInteger('pcf_unique_id')->nullable();
            $table->string('external_link')->nullable();
            $table->string('chl_link')->nullable();
            $table->string('external_transcript')->nullable();
            $table->longText('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('pcf_unique_id');
            $table->dropColumn('external_link');
            $table->dropColumn('chl_link');
            $table->dropColumn('external_transcript');
            $table->dropColumn('notes');
        });
    }
};
