<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('headline');
            $table->mediumText('text');
            $table->date('start_at');
            $table->date('end_at');
            $table->string('type');
            $table->string('group');
            $table->timestamps();
        });

        Schema::create('timelineables', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('timelineable_id');
            $table->string('timelineable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timelineables');
        Schema::dropIfExists('events');
    }
}
