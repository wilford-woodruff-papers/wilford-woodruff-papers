<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \App\Models\Role::firstOrCreate(['name' => 'Researcher']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
