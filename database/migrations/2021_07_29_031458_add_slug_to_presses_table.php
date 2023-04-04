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
        Schema::table('presses', function (Blueprint $table) {
            $table->string('slug')->nullable()->index();
        });

        $presses = \App\Models\Press::all();
        $presses->each(function ($press) {
            $press->generateSlug();
            $press->save();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presses', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
