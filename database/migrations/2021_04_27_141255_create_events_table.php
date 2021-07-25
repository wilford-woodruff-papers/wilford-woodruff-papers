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
            $table->string('headline')->nullable();
            $table->mediumText('text')->nullable();
            $table->date('start_at')->nullable();
            $table->date('end_at')->nullable();
            $table->string('start_year');
            $table->string('start_month')->nullable();
            $table->string('start_day')->nullable();
            $table->string('end_year')->nullable();
            $table->string('end_month')->nullable();
            $table->string('end_day')->nullable();
            $table->string('type')->nullable();
            $table->string('group')->nullable();
            $table->boolean('imported')->default(0);
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
