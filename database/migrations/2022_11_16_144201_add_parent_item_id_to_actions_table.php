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
        Schema::table('actions', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_item_id')
                    ->after('actionable_id')
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
        Schema::table('actions', function (Blueprint $table) {
            $table->dropColumn('parent_item_id');
        });
    }
};
