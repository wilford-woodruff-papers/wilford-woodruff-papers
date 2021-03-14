<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->efficientUuid('uuid')->index();
            $table->string('title')->nullable();
            $table->mediumText('description')->nullable();
            $table->date('date')->nullable();
            $table->string('artist_or_photographer')->nullable();
            $table->string('location')->nullable();
            $table->string('journal_reference')->nullable();
            $table->string('identification_source')->nullable();
            $table->string('editor')->nullable();
            $table->mediumText('notes')->nullable();
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
        Schema::dropIfExists('photos');
    }
}
