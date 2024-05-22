<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('copyright_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        \App\Models\CopyrightStatus::create([
            'name' => 'Not Evaluated',
        ]);
        \App\Models\CopyrightStatus::create([
            'name' => 'In Copyright',
        ]);
        \App\Models\CopyrightStatus::create([
            'name' => 'Public Domain',
        ]);
        \App\Models\CopyrightStatus::create([
            'name' => 'No Known Copyright',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('copyright_statuses');
    }
};
