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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->mediumText('description')->nullable();
            $table->string('image')->nullable();
            $table->dateTime('start_publishing_at');
            $table->dateTime('end_publishing_at')->nullable();
            $table->string('link', 2048)->nullable();
            $table->string('button_text', 2048)->nullable();
            $table->string('button_link', 2048)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announcements');
    }
};
