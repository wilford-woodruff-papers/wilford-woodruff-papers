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
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Page::class)
                ->onDelete('cascade')
                ->constrained('pages');
            $table->mediumText('text');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });

        Schema::create('subject_theme', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Theme::class);
            $table->foreignIdFor(\App\Models\Subject::class);
            $table->timestamps();
            $table->dateTime('approved_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unique(['theme_id', 'subject_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_theme');
        Schema::dropIfExists('themes');
    }
};
