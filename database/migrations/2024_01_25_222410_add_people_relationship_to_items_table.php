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
        Schema::table('items', function (Blueprint $table) {
            $table->foreignId('from_subject_id')
                ->nullable()
                ->constrained('subjects');
            $table->foreignId('to_subject_id')
                ->nullable()
                ->constrained('subjects');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('to_subject_id');
            $table->dropColumn('from_subject_id');
        });
    }
};
