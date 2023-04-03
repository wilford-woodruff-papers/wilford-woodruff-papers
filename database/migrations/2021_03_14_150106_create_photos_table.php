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
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->efficientUuid('uuid')->index();
            $table->string('filename')->nullable()->index();
            $table->string('title')->nullable();
            $table->mediumText('description')->nullable();
            $table->string('date')->nullable();
            $table->string('artist_or_photographer')->nullable();
            $table->string('location')->nullable();
            $table->mediumText('journal_reference')->nullable();
            $table->mediumText('identification')->nullable();
            $table->string('editor')->nullable();
            $table->mediumText('notes')->nullable();
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
        Schema::dropIfExists('photos');
    }
};
