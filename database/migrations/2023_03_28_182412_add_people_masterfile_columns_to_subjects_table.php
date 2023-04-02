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
        Schema::table('subjects', function (Blueprint $table) {
            $table->integer('unique_id')->after('id')->nullable();
            $table->string('reference')->nullable();
            $table->string('relationship')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('death_date')->nullable();
            $table->string('life_years')->nullable();
            $table->string('pid')->after('hide_on_index')->nullable();
            $table->string('added_to_ftp_at')->nullable();
            $table->string('alternate_names')->nullable();
            $table->string('middle_name')->after('first_name')->nullable();
            $table->string('suffix')->nullable();
            $table->string('maiden_name')->nullable();
            $table->string('baptism_date')->nullable();
            $table->longText('notes')->nullable();
            $table->foreign('researcher_id')->references('id')->on('users');
            $table->string('bio_completed_at')->after('pid_identified_at')->nullable();
            $table->string('log_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subjects', function (Blueprint $table) {
            //
        });
    }
};
