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
    public function up(): void
    {
        Schema::create('target_publish_dates', function (Blueprint $table) {
            $table->id();
            $table->date('publish_at');
            $table->timestamps();
        });

        Schema::create('item_target_publish_date', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->restrictOnDelete('cascade');
            $table->foreignId('target_publish_date_id')->constrained('target_publish_dates')->restrictOnDelete('cascade');
            $table->unique(['item_id', 'target_publish_date_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('item_target_publish_date');
        Schema::dropIfExists('target_publish_dates');
    }
};
