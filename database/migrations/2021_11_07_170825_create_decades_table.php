<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDecadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('decades', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('beginning_year');
            $table->smallInteger('ending_year');
        });

        Schema::table('items', function (Blueprint $table) {
            $table->smallInteger('decade')->nullable()->index();
        });

        \App\Models\Decade::insert([
            ['beginning_year' => 1770, 'ending_year' => 1779],
            ['beginning_year' => 1780, 'ending_year' => 1789],
            ['beginning_year' => 1790, 'ending_year' => 1799],
            ['beginning_year' => 1800, 'ending_year' => 1809],
            ['beginning_year' => 1810, 'ending_year' => 1819],
            ['beginning_year' => 1820, 'ending_year' => 1829],
            ['beginning_year' => 1830, 'ending_year' => 1839],
            ['beginning_year' => 1840, 'ending_year' => 1849],
            ['beginning_year' => 1850, 'ending_year' => 1859],
            ['beginning_year' => 1860, 'ending_year' => 1869],
            ['beginning_year' => 1870, 'ending_year' => 1879],
            ['beginning_year' => 1880, 'ending_year' => 1889],
            ['beginning_year' => 1890, 'ending_year' => 1900],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('decades');
    }
}
