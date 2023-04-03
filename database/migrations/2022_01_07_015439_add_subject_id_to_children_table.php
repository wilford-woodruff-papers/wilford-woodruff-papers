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
        Schema::table('children', function (Blueprint $table) {
            $table->unsignedBigInteger('person_id')
                    ->nullable()
                    ->after('id');

            $table->foreign('person_id')
                    ->references('id')
                    ->on('subjects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('children', function (Blueprint $table) {
            $table->dropColumn('person_id');
        });
    }
};
