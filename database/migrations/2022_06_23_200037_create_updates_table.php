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
        Schema::dropIfExists('newsletters');

        Schema::create('updates', function (Blueprint $table) {
            $table->id();
            $table->boolean('enabled')->default(0);
            $table->string('type')->nullable();
            $table->string('campaign_id')->nullable();
            $table->string('subject')->nullable();
            $table->string('slug')->nullable();
            $table->string('preheader')->nullable();
            $table->string('primary_image')->nullable();
            $table->string('link')->nullable();
            $table->longText('content')->nullable();
            $table->dateTime('publish_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('updates');
    }
};
