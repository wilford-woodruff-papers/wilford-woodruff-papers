<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        DB::statement('alter table `board_members` modify name varchar(191) null;');
        DB::statement('alter table `board_members` modify bio mediumtext null;');
    }
};
