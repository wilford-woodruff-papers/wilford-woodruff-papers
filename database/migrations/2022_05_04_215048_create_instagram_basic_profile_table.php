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
        Schema::create('dymantic_instagram_basic_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('identity_token')->nullable();
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dymantic_instagram_basic_profiles');
    }
};
