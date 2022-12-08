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
        Schema::table('teams', function (Blueprint $table) {
            $table->boolean('expanded')
                ->default(1);
        });

        \App\Models\Team::updateOrCreate([
            'name' => 'Emeritus Board Members & Advisors',
        ], [
            'expanded' => false,
        ]);

        Schema::table('board_members', function (Blueprint $table) {
            $table->string('supporting_person_name')
                ->nullable();
            $table->string('supporting_person_link')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('expanded');
        });

        Schema::table('board_members', function (Blueprint $table) {
            $table->dropColumn('supporting_person_name');
            $table->dropColumn('supporting_person_link');
        });
    }
};
