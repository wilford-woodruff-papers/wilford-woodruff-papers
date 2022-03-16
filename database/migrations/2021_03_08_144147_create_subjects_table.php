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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->index();
            $table->string('name');
            $table->string('index')->nullable();
            $table->longText('bio')->nullable();
            $table->mediumText('footnotes')->nullable();
            $table->string('address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->json('geolocation')->nullable();
            $table->boolean('enabled')->default(0);
            $table->timestamps();
        });

        Schema::create('category_subject', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('subject_id');
            $table->primary(['category_id', 'subject_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('category_subject');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('categories');
    }
};
