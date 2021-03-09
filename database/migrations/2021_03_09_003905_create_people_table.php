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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->index();
            $table->string('name');
            $table->string('index');
            $table->boolean('enabled')->default(0);
            $table->timestamps();
        });

        Schema::create('wives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->string('mother');
            $table->string('father');
            $table->date('birthdate');
            $table->date('deathdate');
            $table->string('relationship');
            $table->string('marriage');
            $table->string('sealing');
            $table->date('divorce');
            $table->string('prior_marriage');
            $table->string('subsequent_marriage');
            $table->timestamps();

            $table->foreign('person_id')
                    ->references('id')
                    ->on('people');
        });



        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wife_id');
            $table->string('gender');
            $table->string('birthplace');
            $table->date('birthdate');
            $table->string('deathplace');
            $table->date('deathdate');
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
