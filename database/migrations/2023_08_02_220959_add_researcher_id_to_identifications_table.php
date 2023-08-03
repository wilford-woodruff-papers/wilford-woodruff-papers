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
        Schema::table('identifications', function (Blueprint $table) {
            $table->foreignId('researcher_id')
                ->after('type')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->boolean('skip_tagging')
                ->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('identifications', function (Blueprint $table) {
            $table->dropColumn('skip_tagging');
            $table->dropForeign('identifications_researcher_id_foreign');
            $table->dropColumn('researcher_id');
        });
    }
};
