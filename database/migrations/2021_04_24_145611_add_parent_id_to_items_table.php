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
            $table->unsignedBigInteger('item_id')->nullable();
            $table->unsignedInteger('order')->nullable();

            $table->foreign('item_id')
                ->references('id')
                ->on('items');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_item_id')->nullable();

            $table->foreign('parent_item_id')
                ->references('id')
                ->on('items');
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
            $table->dropConstrainedForeignId('item_id');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropConstrainedForeignId('parent_item_id');
        });
    }
};
