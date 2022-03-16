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
    public function up()
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
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presses', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
