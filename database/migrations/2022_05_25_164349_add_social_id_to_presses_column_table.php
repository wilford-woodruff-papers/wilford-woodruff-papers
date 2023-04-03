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
        Schema::table('presses', function (Blueprint $table) {
            $table->string('cover_image', '2048')->change();
            $table->string('social_id')->after('type')->index()->nullable();
            $table->string('social_type')->after('social_id')->nullable();
            $table->schemalessAttributes('extra_attributes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('presses', function (Blueprint $table) {
            $table->dropColumn('extra_attributes');
            $table->dropColumn('social_type');
            $table->dropColumn('social_id');
        });
    }
};
