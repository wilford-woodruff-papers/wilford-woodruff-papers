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
        Schema::table('relationship_finder_queue', function (Blueprint $table) {
            $table->unsignedBigInteger('batch_id')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('relationship_finder_queue', function (Blueprint $table) {
            $table->dropColumn('batch_id');
        });
    }
};
