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
            $table->integer('total_likes')->default(0);
            $table->integer('total_comments')->default(0);
            $table->dateTime('last_liked_at')->nullable();
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
            $table->dropColumn('total_likes');
            $table->dropColumn('total_comments');
            $table->dropColumn('last_liked_at');
        });
    }
};
