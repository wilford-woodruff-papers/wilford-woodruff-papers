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
            $table->string('middle_name')->after('first_name')->nullable();
            $table->string('suffix')->after('last_name')->nullable();
            $table->string('alternate_names')->after('suffix')->nullable();
            $table->string('maiden_name')->after('alternate_names')->nullable();
            $table->string('baptism_date')->after('birth_date')->nullable();
            $table->longText('notes')->nullable();
            $table->string('researcher_text')->nullable();
            $table->unsignedBigInteger('researcher_id')->nullable();
            $table->string('bio_completed_at')->after('pid_identified_at')->nullable();
            $table->string('log_link')->nullable();

            $table->foreign('researcher_id')->references('id')->on('users');
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
            $table->dropColumn('unique_id');
            $table->dropColumn('reference');
            $table->dropColumn('relationship');
            $table->dropColumn('birth_date');
            $table->dropColumn('death_date');
            $table->dropColumn('life_years');
            $table->dropColumn('pid');
            $table->dropColumn('added_to_ftp_at');
            $table->dropColumn('alternate_names');
            $table->dropColumn('middle_name');
            $table->dropColumn('suffix');
            $table->dropColumn('maiden_name');
            $table->dropColumn('baptism_date');
            $table->dropColumn('notes');
            $table->dropForeign('subjects_researcher_id_foreign');
            $table->dropColumn('bio_completed_at');
            $table->dropColumn('log_link');
            $table->dropColumn('researcher_id');
            $table->dropColumn('researcher_text');
        });
    }
};
