<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->integer('missing_page_count')
                ->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->dropColumn('missing_page_count');
        });
    }
};
