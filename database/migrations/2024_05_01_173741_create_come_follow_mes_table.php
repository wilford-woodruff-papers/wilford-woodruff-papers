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
        Schema::create('come_follow_mes', function (Blueprint $table) {
            $table->id();
            $table->string('book');
            $table->unsignedInteger('week');
            $table->string('date');
            $table->string('reference');
            $table->mediumText('title');
            $table->text('quote')
                ->nullable();
            $table->unsignedBigInteger('page_id')
                ->nullable();
            $table->string('article_link', 2048)
                ->nullable();
            $table->string('video_link')
                ->nullable();
            $table->timestamps();

            $table->foreign('page_id')
                ->references('id')
                ->on('pages')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('come_follow_mes');
    }
};
