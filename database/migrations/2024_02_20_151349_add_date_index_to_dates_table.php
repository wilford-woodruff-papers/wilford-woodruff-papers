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
        Schema::table('dates', function (Blueprint $table) {
            $table->index('date');
        });

        Schema::table('items', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id')
                ->nullable();

            $table->foreign('parent_id')
                ->references('id')
                ->on('items');
        });
    }
};
