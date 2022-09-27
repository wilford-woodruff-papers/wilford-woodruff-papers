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
        Schema::table('items', function (Blueprint $table) {
            $table->string('pcf_unique_id');
            $table->string('external_link');
            $table->string('chl_link');
            $table->string('external_transcript');
            $table->longText('notes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('pcf_unique_id');
            $table->dropColumn('external_link');
            $table->dropColumn('chl_link');
            $table->dropColumn('external_transcript');
            $table->dropColumn('notes');
        });
    }
};
