<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presses', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->mediumText('description')->nullable();
            $table->date('date');
            $table->string('link', 2048)->nullable();
            $table->string('embed', 2048)->nullable();
            $table->longText('transcript')->nullable();
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
        Schema::dropIfExists('presses');
    }
}
