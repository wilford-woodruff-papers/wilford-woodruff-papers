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
        Schema::create('contest_submissions', function (Blueprint $table) {
            $table->id();
            $table->efficientUuid('uuid')->index();
            $table->string('title')->nullable();
            $table->string('status')->nullable();
            $table->string('division')->nullable();
            $table->string('category')->nullable();
            $table->string('medium')->nullable();
            $table->longText('collaborators')->nullable();
            $table->timestamps();
        });

        Schema::create('contestants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contest_submission_id')
                    ->constrained()
                    ->onDelete('cascade');
            $table->efficientUuid('uuid')->index();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email');
            $table->string('address')->nullable();
            $table->boolean('is_primary_contact')->default(0);
            $table->boolean('is_original')->default(0);
            $table->boolean('is_appropriate')->default(0);
            $table->boolean('subscribe_to_newsletter')->default(0);
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
        Schema::dropIfExists('contestants');
        Schema::dropIfExists('contest_submissions');
    }
};
