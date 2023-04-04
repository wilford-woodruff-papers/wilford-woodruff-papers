<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('items', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->integer('missing_page_count')
                ->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->dropColumn('missing_page_count');
        });
    }
};
