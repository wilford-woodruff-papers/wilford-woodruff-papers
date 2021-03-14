<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('wives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->string('marriage_year');
            $table->string('mother')->nullable();
            $table->string('father')->nullable();
            $table->string('birthdate')->nullable();
            $table->string('deathdate')->nullable();
            $table->string('relationship')->nullable();
            $table->string('marriage')->nullable();
            $table->string('sealing')->nullable();
            $table->string('divorce')->nullable();
            $table->string('prior_marriage')->nullable();
            $table->string('subsequent_marriage')->nullable();
            $table->timestamps();

            $table->foreign('person_id')
                    ->references('id')
                    ->on('subjects');
        });



        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wife_id');
            $table->string('name');
            $table->string('gender');
            $table->string('birthplace')->nullable();
            $table->string('birthdate')->nullable();
            $table->string('deathplace')->nullable();
            $table->string('deathdate')->nullable();
            $table->timestamps();

            $table->foreign('wife_id')
                ->references('id')
                ->on('wives');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
    }
}
