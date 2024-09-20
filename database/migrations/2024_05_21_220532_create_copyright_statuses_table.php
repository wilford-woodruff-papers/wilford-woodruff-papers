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
            'name' => 'Copyright not evaluated',
        ]);
        \App\Models\CopyrightStatus::create([
            'name' => 'In copyright',
        ]);
        \App\Models\CopyrightStatus::create([
            'name' => 'No copyright',
        ]);
        \App\Models\CopyrightStatus::create([
            'name' => 'No known copyright',
        ]);
        \App\Models\CopyrightStatus::create([
            'name' => 'Public Domain',
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
