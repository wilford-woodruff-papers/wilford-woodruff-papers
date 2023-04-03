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
        Schema::table('quotes', function (Blueprint $table) {
            $table->boolean('continued_from_previous_page')
                ->after('text')
                ->nullable();
            $table->boolean('continued_on_next_page')
                ->after('text')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropColumn('continued_on_next_page');
        });
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropColumn('continued_from_previous_page');
        });
    }
};
