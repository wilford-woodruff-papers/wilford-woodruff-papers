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
        Schema::create('ai_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')
                ->nullable();
            $table->timestamps();
        });

        Schema::create('ai_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ai_session_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->text('question')
                ->nullable();
            $table->text('answer')
                ->nullable();
            $table->integer('rating')
                ->default(0);
            $table->timestamps();
        });

        Schema::create('ai_question_subject', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ai_question_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('subject_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_question_subject');
        Schema::dropIfExists('ai_questions');
        Schema::dropIfExists('ai_sessions');
    }
};
