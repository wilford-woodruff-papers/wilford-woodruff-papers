<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('identifications', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('editorial_assistant')->nullable();
            $table->string('title')->nullable();
            $table->string('first_middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('other')->nullable();
            $table->text('link_to_ftp')->nullable();
            $table->longText('guesses')->nullable();
            $table->string('location')->nullable();
            $table->date('completed_at')->nullable();
            $table->longText('notes')->nullable();
            $table->string('fs_id')->nullable();
            $table->string('approximate_birth_date')->nullable();
            $table->string('approximate_death_date')->nullable();
            $table->text('nauvoo_database')->nullable();
            $table->text('pioneer_database')->nullable();
            $table->text('missionary_database')->nullable();
            $table->text('boston_index')->nullable();
            $table->text('st_louis_index')->nullable();
            $table->text('british_mission')->nullable();
            $table->text('eighteen_forty_census')->nullable();
            $table->text('eighteen_fifty_census')->nullable();
            $table->text('eighteen_sixty_census')->nullable();
            $table->text('other_census')->nullable();
            $table->text('other_records')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identifications');
    }
};
